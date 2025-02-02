<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Oeuvre;
use App\Entity\TypeAuteur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomoupseudo')
            ->add('prenom')
            ->add('type', EntityType::class, [
                'class' => TypeAuteur::class,
                'choice_label' => 'id',
            ])
            ->add('oeuvres', EntityType::class, [
                'class' => Oeuvre::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
