<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Sortie;
use Doctrine\DBAL\Types\DateType;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreSortieType extends AbstractType
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
                'label'=> 'contient: ',
                'required' => false,
                'attr' => ['placeholder'=> 'Nom sotie']
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
            'data_class' => Sortie::class,
        ]);
    }
}
