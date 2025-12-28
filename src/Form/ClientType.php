<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TelType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('dateInscription', DateType::class, [
                'label' => 'Date d’inscription',
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nomComplet', // méthode __toString ou getter
                'placeholder' => 'Sélectionner un utilisateur',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
