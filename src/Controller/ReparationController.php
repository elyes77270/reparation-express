<?php

namespace App\Controller;

use App\Entity\Composant;
use App\Entity\ComposantTelephone;
use App\Entity\Marque;
use App\Entity\ReparationSoumission;
use App\Entity\Telephone;
use App\Form\ReparationSoumissionType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class ReparationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reparation', name: 'app_reparation')]
    public function index(): Response
    {
        $marques = $this->entityManager->getRepository(Marque::class)->findAll();

        return $this->render('reparation/index.html.twig', [
            'marques' => $marques,
        ]);
    }

    #[Route('/reparation/{marque}', name: 'app_marque')]
    public function marque(string $marque): Response
    {
        $marqueEntity = $this->entityManager->getRepository(Marque::class)->findOneBy(['nom' => $marque]);

        if (!$marqueEntity) {
            throw $this->createNotFoundException('Marque not found');
        }

        $telephones = $marqueEntity->getTelephones();

        return $this->render('reparation/marque.html.twig', [
            'marque' => $marqueEntity,
            'telephones' => $telephones,
        ]);
    }

    #[Route('/reparation/{marque}/{telephone}', name: 'app_marque_telephone')]
    public function showTelephone(string $marque, string $telephone, Request $request, SessionInterface $session): Response
    {
        $marqueEntity = $this->entityManager->getRepository(Marque::class)->findOneBy(['nom' => $marque]);

        if (!$marqueEntity) {
            throw $this->createNotFoundException('Marque not found');
        }

        $telephoneEntity = $this->entityManager->getRepository(Telephone::class)->findOneBy(['marque' => $marqueEntity, 'nom' => $telephone]);

        if (!$telephoneEntity) {
            throw $this->createNotFoundException('Telephone not found');
        }

        if ($request->isMethod('POST')) {

            // Récupérez les composants sélectionnés avec leurs IDs
            $selectedComponents = $request->request->all('selected_components');

            // Filtrer les "on" pour obtenir uniquement les IDs des composants sélectionnés
            $selectedComponentIds = array_filter($selectedComponents, function ($value) {
                return $value === 'on';
            });

            // Stockez les identifiants des composants sélectionnés dans la session Symfony
            $session->set('selected_component_ids', array_keys($selectedComponentIds));

            // Rediriger vers la route app_reparation_confirmation
            return $this->redirectToRoute('app_reparation_confirmation', [
                'marque' => $marque,
                'telephone' => $telephone,
            ]);

        }

        return $this->render('reparation/telephone.html.twig', [
            'marque' => $marqueEntity,
            'telephone' => $telephoneEntity,
        ]);
    }

    #[Route('/reparation/{marque}/{telephone}/confirmation', name: 'app_reparation_confirmation')]
    public function confirmation(string $marque, string $telephone, Request $request, SessionInterface $session): Response
    {
        $marqueEntity = $this->entityManager->getRepository(Marque::class)->findOneBy(['nom' => $marque]);

        if (!$marqueEntity) {
            throw $this->createNotFoundException('Marque not found');
        }

        $telephoneEntity = $this->entityManager->getRepository(Telephone::class)->findOneBy(['marque' => $marqueEntity, 'nom' => $telephone]);

        if (!$telephoneEntity) {
            throw $this->createNotFoundException('Telephone not found');
        }

        $composantTelephoneRepository = $this->entityManager->getRepository(ComposantTelephone::class);
        $selectedComponentIds = $session->get('selected_component_ids');

        $totalPrix = 0;

        // Assurez-vous que les IDs sont non vides
        if (!empty($selectedComponentIds)) {

            $selectedComponents = $composantTelephoneRepository->findBy(['id' => $selectedComponentIds]);

            foreach ($selectedComponentIds as $component) {

                $selectedComponent = $composantTelephoneRepository->find($component);

                if (!$selectedComponent) {
                    throw $this->createNotFoundException('Composant not found');
                }

                $totalPrix += $selectedComponent->getPrix();
                $composantNames[] = $selectedComponent->getComposant()->getNom();

            }

            $composantNamesString = implode(', ', $composantNames);

            $form = $this->createForm(ReparationSoumissionType::class);

            $form->get('telephone')->setData($telephoneEntity->getNom());
            $form->get('composants')->setData($composantNamesString);
            $form->get('totalPrice')->setData($totalPrix);
            $form->get('date')->setData(new \DateTime('now'));

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $reparationSoumission = $form->getData();
                $this->entityManager->persist($reparationSoumission);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_reparation_validation', [
                    'idSoumission' => $reparationSoumission->getId(),
                ]);
            }
        } else {
            return $this->redirectToRoute('app_marque_telephone', [
                'marque' => $marque,
                'telephone' => $telephone,
            ]);
        }

        return $this->render('reparation/confirmation.html.twig', [
            'marque' => $marqueEntity,
            'telephone' => $telephoneEntity,
            'selectedComponents' => $selectedComponents,
            'totalPrix' => $totalPrix,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/validation-reparation/{idSoumission}/', name: 'app_reparation_validation')]
    public function validation(
        string $idSoumission,
        MailerInterface $mailer,
    ): Response {

        $reparationSoumission = $this->entityManager->getRepository(ReparationSoumission::class)->find($idSoumission);


        $selectedComponents = $reparationSoumission->getComposants();
        $totalPrice = $reparationSoumission->getTotalPrice();
        $telephone = $reparationSoumission->getTelephone();
        $email = $reparationSoumission->getEmail();
        $number = $reparationSoumission->getTel();
        $date = $reparationSoumission->getDate()->format('d/m/Y');

        // Create a PDF with the summary
        $pdf = new Pdf();
        $pdf->setBinary('/usr/bin/wkhtmltopdf');
        $pdfContent = $pdf->getOutputFromHtml($this->renderView('mail/pdf_summary.html.twig', [
            'telephone' => $telephone,
            'selectedComponents' => $selectedComponents,
            'totalPrice' => $totalPrice,
            'tel' => $number,
            'email' => $email,
            'date' => $date,
        ]));

        // Send the PDF via email
        $emailSend = (new Email())
            ->to($email) // Assuming the email field is named 'email' in the form
            ->from('elyesghazouani29@gmail.com')
            ->subject('Résumé de la réparation')
            ->text('Résumé de la réparation attaché en PDF.')
            ->attach($pdfContent, 'reparation_summary.pdf', 'application/pdf');

        $mailer->send($emailSend);

        // Render a view with a download button
        return $this->render('reparation/validation.html.twig', [
            'email' => $email,
            'idSoumission' => $idSoumission,
        ]);
    }

    #[Route('/download-pdf/{idSoumission}', name: 'app_download_pdf')]
    public function downloadPdf(string $idSoumission): Response
    {
        $reparationSoumission = $this->entityManager->getRepository(ReparationSoumission::class)->find($idSoumission);

        if (!$reparationSoumission) {
            throw $this->createNotFoundException('Reparation Soumission not found');
        }

        $pdfContent = $this->generatePdfContent($reparationSoumission);

        $response = new Response($pdfContent);
        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'inline; filename="reparation_summary.pdf"');

        return $response;
    }

    private function generatePdfContent(ReparationSoumission $reparationSoumission): string
    {
        $selectedComponents = $reparationSoumission->getComposants();
        $totalPrice = $reparationSoumission->getTotalPrice();
        $telephone = $reparationSoumission->getTelephone();
        $email = $reparationSoumission->getEmail();
        $number = $reparationSoumission->getTel();
        $date = $reparationSoumission->getDate()->format('d/m/Y');

        $pdf = new Pdf();
        $pdf->setBinary('/usr/bin/wkhtmltopdf');
        $pdfContent = $pdf->getOutputFromHtml($this->renderView('mail/pdf_summary.html.twig', [
            'telephone' => $telephone,
            'selectedComponents' => $selectedComponents,
            'totalPrice' => $totalPrice,
            'tel' => $number,
            'email' => $email,
            'date' => $date,
        ]));

        return $pdfContent;
    }



}
