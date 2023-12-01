<?php

namespace App\Form;
use App\Entity\Composant;
use App\Entity\ComposantTelephone;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComposantFieldType extends AbstractType
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $composants = $this->entityManager->getRepository(Composant::class)->findAll();

        $choices = [];
        foreach ($composants as $composant) {
            $choices[$composant->getNom()] = $composant;
        }

        $builder
            ->add('composant', ChoiceType::class, [
                'label' => 'Composant',
                'choices' => $choices,
                'placeholder' => 'Choose a composant',
                'attr' => [
                    'class' => 'composant-field',
                ],
                'choice_label' => 'nom',
                'choice_value' => 'id',
            ])
            ->add('prix', NumberType::class, [
                'label' => 'Prix',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ComposantTelephone::class,
        ]);
    }
}