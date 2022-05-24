<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        ->add('campus', EntityType::class, [
        'class'=>Campus::class,
        'choice_label' => 'nom',
        'placeholder'=> 'Choisir un campus',
        'required' => false,
    ])

        ->add('nom', TextType::class, [
            'label'=> 'Contient: ',
            'required' => false,
            'attr' => ['placeholder'=> 'Nom sortie']
        ])

        ->add('dateDebut', DateType::class, [
            'widget' => 'single_text',
            'format' => '(d-m-Y)',
            'required' => false,
            'html5' => false,
            'attr' => ['placeholder' => 'jj/mm/aaaa']
        ])

        ->add('dateFin', DateType::class, [
            'widget' => 'single_text',
            'format' => '(d-m-Y)',
            'required' => false,
            'html5' => false,
            'attr' => ['placeholder' => 'jj/mm/aaaa']
        ] )

        ->add('organisateur', CheckboxType::class, [
            'label' => "Sortie(s) que j'organise",
            'required'=>false
        ])

        ->add('inscrit', CheckboxType::class, [
            'label' => "Sortie(s) où je suis inscrit(e)",
            'required'=>false
        ])

        ->add('nonInscrit', CheckboxType::class, [
            'label' => "Sortie(s) où je ne suis pas inscrit(e)",
            'required'=>false
        ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
