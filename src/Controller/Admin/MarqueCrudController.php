<?php

namespace App\Controller\Admin;

use App\Entity\Marque;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MarqueCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Marque::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Marque')
            ->setEntityLabelInPlural('Marques')
            ->setSearchFields(['nom']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield ImageField::new('image')
            ->setBasePath('/uploads/images/') // Chemin vers le dossier des images
            ->setUploadDir('public/uploads/images/') // Chemin vers le dossier d'upload des images
            ->setUploadedFileNamePattern('[randomhash].[extension]') // Patron de nom de fichier pour les images téléchargées
            ->setRequired(false); // Le champ n'est pas obligatoire

        yield TextField::new('nom');

        yield AssociationField::new('telephones')
            ->hideOnForm()
            ->setFormTypeOptions([
                'by_reference' => false, // Nécessaire pour permettre l'ajout/suppression de téléphones depuis le formulaire
                'multiple' => true // Permet la sélection multiple des téléphones dans le formulaire
            ]);
    }
}
