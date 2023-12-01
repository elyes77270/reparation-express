<?php

namespace App\Controller\Admin;

use App\Entity\ReparationSoumission;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ReparationSoumissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ReparationSoumission::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email', 'Email'),
            TelephoneField::new('tel', 'Numéro'),
            BooleanField::new('promo_email', 'Promo Email'),
            BooleanField::new('pub_email', 'Pub Email'),
            TextField::new('telephone', 'Modèle'),
            TextField::new('composants', 'Composants'),
            NumberField::new('totalPrice', 'Prix total'),
            DateField::new('date', 'Date'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return parent::configureActions($actions)
            ->remove(
                Crud::PAGE_INDEX,
                Action::NEW
            )
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}