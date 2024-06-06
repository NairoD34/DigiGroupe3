<?php

namespace App\Services;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;



class FormHandlerService
{

    public function __construct(
        private EntityManagerInterface $em,
        private PasswordHasherService $passwordHasher,
    )
    {}
 
    public function handleForm ( 
        FormInterface   $form, 
        Request         $request,
        bool            $flush = false,
    ) :bool
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $this->em->persist($form->getData());
            if ($flush){
                $this->em->flush();
            }
            return true;
        }
        return false;
    }

    public function handleFormHashed(
        FormInterface   $form,
        Request         $request,
        User            $user,
        bool            $flush = false,
    ) : bool
    {
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
        $this->em->persist($this->passwordHasher->userHashPassword($user));
        if ($flush){
            $this->em->flush();
        }
        return true;
        }
        return false;
    }
}
