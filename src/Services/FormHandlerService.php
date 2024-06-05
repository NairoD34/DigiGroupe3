<?php

namespace App\Services;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;



class FormHandlerService
{

    public function __construct(
        private EntityManagerInterface $em,
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
}
