<?php

namespace App\Form;

use App\Entity\Boat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoatType extends LocationType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        $builder
            ->add('roofHeight', NumberType::class, [
                'label' => "Hauteur du toit",
                'attr' => [
                    'placeholder' => "Hauteur du toit",
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('motor')
            ->add('isMoving')
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => ['class' => 'btn btn-red']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Boat::class,
        ]);
    }
}
