<?php

namespace App\Form;

use App\Entity\CompteBancaire;
use App\Entity\Solde;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteBancaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compteBancaire', ChoiceType::class, [
                'choices' => [
                    'Compte Courant' => 'courant',
                    'Compte d\'Épargne' => 'epargne',
                    'Compte Joint' => 'joint',
                    'Compte Professionnel' => 'professionnel',
                    'Compte Titre' => 'titre',
                    'Compte à Terme' => 'terme',
                    'Compte en Devises' => 'devises',
                ],
                'label' => 'Type de Compte',
            ])
            ->add('created_at', DateTimeType::class, [
                'widget' => 'single_text',
                'label' => 'Date de création',
            ])
           
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
                'label' => 'Utilisateur',
            ])
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompteBancaire::class,
        ]);
    }
}
