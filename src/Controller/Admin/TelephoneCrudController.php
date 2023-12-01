<?php

namespace App\Controller\Admin;

use App\Entity\Composant;
use App\Entity\Telephone;
use App\Form\ComposantFieldType;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class TelephoneCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Telephone::class;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('nom')
            ->add('marque')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('nom');
        yield ImageField::new('image')->setUploadDir('/public/uploads/images')->setBasePath('/uploads/images')->setRequired(false);
        yield AssociationField::new('marque');
        yield CollectionField::new('composantTelephones', 'Composants')
            ->setFormTypeOptions([
                'by_reference' => false,
                'entry_type' => ComposantFieldType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
                'attr' => [
                    'class' => 'composant-telephones',
                ],
            ])
            ->setRequired(true)
            ->setHelp('Specify the price for each selected component.')
            ->hideOnIndex();

    }
}
