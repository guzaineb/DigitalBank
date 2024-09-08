<?php

namespace App\Form;

use App\Entity\CompteBancaire;
use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('description')
            ->add('date_transaction', null, [
                'widget' => 'single_text',
            ])
            ->add('id_donneur', EntityType::class, [
                'class' => CompteBancaire::class,
                'choice_label' => 'id',
                'property_path' => 'id_donneur',
            ])
            ->add('id_recepteur', EntityType::class, [
                'class' => CompteBancaire::class,
                'choice_label' => 'id',
                'property_path' => 'id_recepteur',
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
