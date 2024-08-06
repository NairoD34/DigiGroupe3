<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Client;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class AdminClientFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('company')
            ->add('firstName')
            ->add('lastName')
            ->add('phoneNumber')
            ->add('mail')
            ->add('adress')
            ->add('ZIPcode')
            ->add('city')
            ->add('SIREN')
            ->add('SIRET');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}