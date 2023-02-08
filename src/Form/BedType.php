<?php

namespace App\Form;

use App\Entity\Bed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du lit',
                'attr' => [
                    'placeholder' => 'Nom du lit',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('picture', TextType::class, [
                'label' => 'Photo',
                'attr' => [
                    'placeholder' => 'Photo',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('capacity', NumberType::class, [
                'label' => "Capacité d'accueil",
                'attr' => [
                    'placeholder' => "Capacité d'accueil",
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bed::class,
        ]);
    }
}
