<?php

namespace App\Form;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, ['label'=> 'Nom'])
            ->add('dateHeureDebut', DateTimeType::class, ['label'=> 'Date et heure de debut : ','html5'=> true,'widget'=> 'single_text'] )
            ->add('duree', IntegerType::class, ['attr'=>['min'=>10], 'label'=> 'Duree en minutes :'])
            ->add('dateLimiteInscription',DateTimeType::class, ['html5'=> true,'widget'=> 'single_text'])
            ->add('nbIscriptionsMax',IntegerType::class, ['attr'=>['min'=>0], 'label'=> 'Places disponibles : '])
            ->add('infosSortie', TextareaType::class, ['label'=> 'Description de la sortie : '])
            ->add('lieu', EntityType::class, ['label'=> 'Lieu :',
                'class' => Lieu::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choisir un lieu...'
            ])

//            ->add('siteOrganisateur', EntityType::class, ['label'=> 'Campus',
//                'class' => 'App\Entity\Campus',
//                'choice_label' => 'nom',
//                'placeholder' => 'Choisir un campus...'
//            ])
//            ->add('enregistrer', SubmitType::class, ['label' => 'Enregistrer', 'attr' => [
//                'class' => 'btn btn-outline-primary col-lg-1']
//            ])
//            ->add('publier', SubmitType::class, ['label' => 'Publier', 'attr' => [
//                    'class' => 'btn btn-outline-success col-lg-auto']
//                ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
