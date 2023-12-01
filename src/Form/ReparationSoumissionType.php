<?php

namespace App\Form;

use App\Entity\ReparationSoumission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReparationSoumissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'border rounded-pill shadow-sm form-control',
                    'placeholder' => 'Votre Email'
                ]
            ])
            ->add('tel', TelType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'border rounded-pill shadow-sm form-control',
                    'placeholder' => 'Votre numéro de téléphone'
                ]
            ])
            ->add('promo_email', CheckboxType::class, [
                'label' => 'J’accepte de recevoir des promotions ponctuelles (soldes, opérations spéciales...)',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ]
            ])
            ->add('pub_email', CheckboxType::class, [
                'label' => 'J’accepte de recevoir des emails ciblés et automatiques en fonction de mes données de navigation et de mes intérêts',
                'required' => false,
                'attr' => [
                    'class' => 'form-check-input',
                ]
            ])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'class' => 'd-none',
                ],
                'label_attr' => [
                    'class' => 'd-none',
                ]
            ])
            ->add('composants', TextType::class, [
                'attr' => [
                    'class' => 'd-none',
                ],
                'label_attr' => [
                    'class' => 'd-none',
                ]
            ])
            ->add('totalPrice', NumberType::class, [
                'attr' => [
                    'class' => 'd-none',
                ],
                'label_attr' => [
                    'class' => 'd-none',
                ]
            ])
            ->add('date', DateType::class, [
                'attr' => [
                    'class' => 'd-none',
                ],
                'label_attr' => [
                    'class' => 'd-none',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ReparationSoumission::class,
        ]);
    }
}