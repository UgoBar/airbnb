<?php

namespace App\Form;

use App\Controller\ApiController;
use App\Entity\Location;
use App\Service\ApiService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

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
            ->add('picture', TextType::class, [
                'label' => "Lien de l'image",
                'attr' => [
                    'placeholder' => "Lien de l'image",
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                ],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Description',
                ],
            ])
//            ->add('capacity', NumberType::class, [
//                'label' => "Capacité d'accueil",
//                'attr' => [
//                    'placeholder' => "Capacité d'accueil",
//                ],
//                'row_attr' => [
//                    'class' => 'form-floating',
//                ],
//            ])
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
                    'list' => 'cityList',
                ],
                'row_attr' => [
                    'class' => 'form-floating',
                    'id' => 'city'
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
        $builder->addEventListener(FormEvents::POST_SUBMIT ,[$this,'onPostSubmit']);
    }

    public function onPreSetData(FormEvent $formEvent)
    {
        $location = $formEvent->getData();
        $form = $formEvent->getForm();

        if($location->getId()){
            $form->remove('address');
        }
    }

    public function onPostSubmit(FormEvent $formEvent)
    {
        /** @var Location $location */
        $location = $formEvent->getData();
        $form = $formEvent->getForm();

        $city = $form->get('city')->getData();
        $conn = $this->entityManager->getConnection();
        $sql = 'SELECT ville_nom, ville_nom_reel, ville_code_postal, ville_longitude_deg, ville_latitude_deg FROM spec_villes_france WHERE ville_nom_reel = :city';
        $result = $conn->prepare($sql)->executeQuery(['city' => $city])->fetchAssociative();

        if($result === false){
            $form->get("city")->addError(new FormError("La ville n'existe pas"));
        } else {
            $location->setLatitude($result['ville_latitude_deg']);
            $location->setLongitude($result['ville_longitude_deg']);
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
