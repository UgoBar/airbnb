<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
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
                'row_attr' => [
                    'class' => 'form-floating',
                ],
            ])
            ->add('description')
            ->add('capacity')
            ->add('address')
            ->add('phone')
            ->add('nbrRoom')
            ->add('priceOneNight', MoneyType::class, [])
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
