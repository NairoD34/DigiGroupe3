<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Services\FormHandlerService;
use App\Services\PasswordHasherService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'login'
    )]
    public function login(
        AuthenticationUtils $authenticationUtils
    ): Response
     {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $email = $authenticationUtils->getLastUsername();

        return $this->render('login/login.html.twig', [
            'title' => 'Connexion',
            'email' => $email, 
            'error' => $error
        ]);
    }

    #[Route(
        path: '/logout', 
        name: 'logout'
    )]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(
        path: '/register',
        name: 'register',
        methods: ['GET', 'POST'],
    )]
    public function register (
        Request $request,
        FormHandlerService $formHandler,
    ): Response
    {
        $user = new User;
        $form = $this->createForm(UserFormType::class, $user);
        if ($formHandler->handleFormHashed($form, $request, $user, true)){
            return $this->redirectToRoute('login');
        }
        return $this->render('login/register.html.twig', [
            'title' => 'Inscription',
            'form' => $form,
        ]);
    }
}
