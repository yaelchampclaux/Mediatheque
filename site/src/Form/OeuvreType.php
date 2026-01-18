<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Edition;
use App\Entity\Lieu;
use App\Entity\Oeuvre;
use App\Entity\Serie;
use App\Entity\TypeOeuvre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placeholder' => 'Titre de l\'œuvre']
            ])
            ->add('photo', TextType::class, [
                'label' => 'Photo (URL)',
                'required' => false,
                'attr' => ['placeholder' => 'https://...']
            ])
            ->add('annee', IntegerType::class, [
                'label' => 'Année de publication',
                'required' => false,
                'attr' => ['placeholder' => date('Y')]
            ])
            ->add('type', EntityType::class, [
                'class' => TypeOeuvre::class,
                'choice_label' => 'type',
                'label' => 'Type d\'œuvre',
                'placeholder' => 'Choisir un type',
                'required' => false
            ])
            ->add('serie', EntityType::class, [
                'class' => Serie::class,
                'choice_label' => 'titre',
                'label' => 'Série',
                'placeholder' => 'Choisir une série',
                'required' => false
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'adresse',
                'label' => 'Lieu',
                'placeholder' => 'Choisir un lieu',
                'required' => false
            ])
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => function(Auteur $auteur) {
                    return $auteur->getNomComplet();
                },
                'multiple' => true,
                'expanded' => false,
                'label' => 'Auteur(s)',
                'attr' => ['class' => 'select2'],
                'by_reference' => false
            ])
            ->add('editions', EntityType::class, [
                'class' => Edition::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'label' => 'Édition(s)',
                'required' => false,
                'attr' => ['class' => 'select2'],
                'by_reference' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Oeuvre::class,
        ]);
    }
}