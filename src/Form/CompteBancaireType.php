<?php

namespace App\Form;

use App\Entity\CompteBancaire;
use App\Entity\Solde;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteBancaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('CompteBancaire')
            ->add('numero_compte')
            ->add('cratted_at', null, [
                'widget' => 'single_text'
            ])
            ->add('updated_at', null, [
                'widget' => 'single_text'
            ])
            ->add('user_id')
            ->add('solde_id', EntityType::class, [
                'class' => Solde::class,
'choice_label' => 'id',
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
