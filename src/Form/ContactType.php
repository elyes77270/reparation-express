<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom_prenom', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'border rounded-pill shadow-sm form-control',
                    'placeholder' => 'Nom Prénom'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'border rounded-pill shadow-sm form-control',
                    'placeholder' => 'Email'
                ]
            ])
            ->add('telephone', TelType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'border rounded-pill shadow-sm form-control',
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'rows' => '6',
                    'placeholder' => 'Votre message'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}