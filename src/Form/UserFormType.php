<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFormType extends AbstractType
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private Security $security,
    )
    {}
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->setMethod("POST");
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $user = $event->getData();
            $form = $event->getForm();

            if (!$user || null === $user->getId()) {
                $form->add('email', EmailType::class, [
                    "label" => "Email",
                    "required" => true,
                ])
                ->add('password', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmer mot de passe'],
                    'invalid_message' => 'fos_user.password.mismatch',
                    'required' => true,
                ])
                ->add('firstName', TextType::class,[
                    'label' => 'Prénom',
                ])
                ->add('lastName', TextType::class,[
                    'label' => 'Nom',
                ])
                ->add('phoneNumber', NumberType::class,[
                    'label' => 'Numéro de téléphone',
                ])
                //->add('job', EntityType::class, [
                //    'class' => Job::class,
                //    'choice_label' => 'label',
                //])
                ->add('submit', SubmitType::class, [
                    'label' => 'Enregistrer',
                ]);
            } else {
                $form->add('email', EmailType::class, [
                    "label" => "Email",
                    "required" => true,
                    'attr' => ['value' => $user->getEmail()],
                ])
                    // TODO : Ajouter la modification de mdp !
                //->add('password', RepeatedType::class, [
                //    'type' => PasswordType::class,
                //    'first_options' => ['label' => 'Mot de passe'],
                //    'second_options' => ['label' => 'Confirmer mot de passe'],
                //    'invalid_message' => 'fos_user.password.mismatch',
                //    'required' => true,
                //])
                ->add('firstName', TextType::class,[
                    'label' => 'Prénom',
                    'attr' => ['value' => $user->getFirstName()],

                ])
                ->add('lastName', TextType::class,[
                    'label' => 'Nom',
                    'attr' => ['value' => $user->getLastName()],

                ])
                ->add('phoneNumber', NumberType::class,[
                    'label' => 'Numéro de téléphone',
                    'attr' => ['value' => $user->getPhoneNumber()],
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Mettre à jour',
                ]);
            }
        });
        // TODO : A ajouter si un admin crée un user !
        // ->add('job', EntityType::class, ['class' => Job::class, 'choice_label' => 'id',])
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
