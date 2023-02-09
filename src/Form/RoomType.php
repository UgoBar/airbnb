<?php

namespace App\Form;

use App\Entity\Room;
use App\Entity\RoomBed;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('hasBathroom')
            ->add('hasBalcony')
            /** https://symfony.com/doc/current/form/form_collections.html */
            ->add('roomBeds', CollectionType::class, [
                'entry_type' => RoomBedType::class,
                'by_reference' => false,
                "label"=>false,
                'allow_add' => true,
                'allow_delete' => true,
//                'entry_options' => [
//                    'attr' => ['class' => 'email-box'],
//                ],
            ])
            ->add('quantity', NumberType::class, [
                'mapped' => false,
                'label' => 'Nombre de lits',
                'attr' => [
                    'placeholder' => 'Nombre de lits',
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
            'data_class' => Room::class,
        ]);
    }
}
