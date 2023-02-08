<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre logement',
                'attr' => [
                    'placeholder' => 'Nom de votre logement',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description',
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
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'Adresse',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'Ville',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'placeholder' => 'Téléphone',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('nbrRoom', NumberType::class, [
                'label' => 'Nombre de chambre',
                'attr' => [
                    'placeholder' => 'Nombre de chambre',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('priceOneNight', MoneyType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Prix par nuit',
                ],
            ])
        ;
        $builder->addEventListener(FormEvents::PRE_SET_DATA ,[$this,'onPreSetData']);
    }

    public function onPreSetData(FormEvent $formEvent)
    {
        $location = $formEvent->getData();
        $form = $formEvent->getForm();

        if($location->getId()){
            $form->remove('address');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
