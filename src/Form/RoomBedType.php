<?php

namespace App\Form;

use App\Entity\Bed;
use App\Entity\RoomBed;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomBedType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('bed', EntityType::class, [
                'class' => Bed::class,
                'label' => false,
                'choice_label' => 'name',
                'row_attr' => [
                    'class' => 'collection-form-div',
                ],
            ])
            ->add('quantity', NumberType::class, [
                'label' => 'Nombre de lits',
                'attr' => [
                    'placeholder' => 'Nombre de lits',
                ],
                'row_attr' => [
                    'class' => 'form-floating collection-form-div',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RoomBed::class,
        ]);
    }
}
