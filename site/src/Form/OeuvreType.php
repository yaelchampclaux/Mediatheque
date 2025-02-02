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
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OeuvreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('photo')
            ->add('annee')
            ->add('auteurs', EntityType::class, [
                'class' => Auteur::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('editions', EntityType::class, [
                'class' => Edition::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('type', EntityType::class, [
                'class' => TypeOeuvre::class,
                'choice_label' => 'id',
            ])
            ->add('serie', EntityType::class, [
                'class' => Serie::class,
                'choice_label' => 'id',
            ])
            ->add('Lieu', EntityType::class, [
                'class' => Lieu::class,
                'choice_label' => 'id',
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
