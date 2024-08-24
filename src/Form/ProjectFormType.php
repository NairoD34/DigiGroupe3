<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\StateOfProject;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('start_date', null, [
                'widget' => 'single_text'
            ])
            ->add('end_date', null, [
                'widget' => 'single_text'
            ])
            ->add('manages', EntityType::class, [
                'class' => User::class,
'choice_label' => 'firstName',
            ])
            ->add('stateOfProject', EntityType::class, [
                'class' => StateOfProject::class,
'choice_label' => 'label',
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
'choice_label' => 'firstName',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Soumettre',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
