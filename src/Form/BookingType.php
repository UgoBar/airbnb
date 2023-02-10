<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDateAt', TextType::class, [
                'label' => 'Arrivée prévue le',
                'attr' => [
                    'placeholder' => 'Arrivée prévue le',
                ],
                'disabled' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('endDateAt', TextType::class, [
                'label' => 'Départ prévu le',
                'attr' => [
                    'placeholder' => 'Départ prévu le',
                ],
                'disabled' => true,
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('quantityTraveller', NumberType::class, [
                'label' => 'Nombre de voyageurs',
                'attr' => [
                    'placeholder' => 'Nombre de voyageurs',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'disabled' => true,
            ])
            ->add('totalPrice', MoneyType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix par nuit',
                ],
                'disabled' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'enregistrer',
                'attr' => ['class' => 'btn btn-red']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
