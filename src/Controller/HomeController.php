<?php

namespace App\Controller;

use App\Entity\ReparationSoumission;
use App\Entity\Telephone;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/', name: 'app_home')]
    public function index(Request $request): Response
    {
        $reparationTelephones = $this->entityManager->getRepository(ReparationSoumission::class)
            ->findMostFrequentTelephones();

        $telephones = [];

        foreach ($reparationTelephones as $reparationTelephone){
            $telephone = $this->entityManager->getRepository(Telephone::class)->findBy(['nom' => $reparationTelephone]);
            $telephones = array_merge($telephone);
        }

        if (count($telephones) < 8) {
            $missingCount = 8 - count($telephones);
            $randomTelephones = $this->entityManager->getRepository(Telephone::class)
                ->createQueryBuilder('t')
                ->where('t NOT IN (:telephones)')
                ->setParameter('telephones', $telephones)
                ->setMaxResults($missingCount)
                ->getQuery()
                ->getResult();

            $telephones = array_merge($telephones, $randomTelephones);
        }

        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();

            $this->entityManager->persist($contact);
            $this->entityManager->flush();

            return $this->redirectToRoute('contact_success');
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'telephones' => $telephones,
        ]);
    }
}
