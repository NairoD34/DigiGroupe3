<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Client;
use App\Entity\Project;
use App\Entity\User;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\ChoiceList\Factory\Cache\ChoiceAttr;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class AdminProjectFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('Client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'company',
                'required' => false,
                'placeholder' => '',
                'empty_data' => null,
            ])
            ->add('manages',EntityType::class,[
                'class' => User::class,
                'choice_label' => 'lastName',
            ])
            ->add('participates',EntityType::class,[
                'class' => User::class,
                'label' => 'lastname',
                'multiple' => true,
                'expanded' => true,
            ])
            
            ->add('startDate',DateType::class,[
                'format' => 'dd-MM-yyyy',

            ])
            ->add('endDate',DateType::class,[
                'format' => 'dd-MM-yyyy',

            ]);

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}