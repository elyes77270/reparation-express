<?php

namespace App\Controller\Admin;

use App\Entity\Composant;
use App\Entity\Contact;
use App\Entity\Marque;
use App\Entity\ReparationSoumission;
use App\Entity\Telephone;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        AdminUrlGenerator $adminUrlGenerator
    ){
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(MarqueCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Réparation Express');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Gestion des réparations', 'fa fa-gear')->setSubItems([
             MenuItem::linkToCrud('Marques', 'fa-brands fa-apple', Marque::class),
             MenuItem::linkToCrud('Téléphone', 'fa fa-mobile', Telephone::class),
             MenuItem::linkToCrud('Composant', 'fa fa-cog', Composant::class),
        ]);
        yield MenuItem::subMenu('Réparations', 'fa fa-tools')->setSubItems([
            MenuItem::linkToCrud('Réparations', 'fa fa-message', ReparationSoumission::class),
        ]);
        yield MenuItem::subMenu('Contact', 'fa fa-envelope')->setSubItems([
            MenuItem::linkToCrud('Message', 'fa fa-message', Contact::class),
        ]);
    }
}
