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
        path: '/login', 
        name: 'login'
    )]
    public function login(
        AuthenticationUtils $authenticationUtils
    ): Response
     {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

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
        path: '/dashboard',
        name: 'dashboard',
        methods: ['GET'],
    )]
    public function dashboard(Security $security) : Response
    {
        if ($user = $security->getUser() === null) {
            return $this->redirectToRoute('login');
        }
        $user = $this->getUser();
        return $this->render('login/dashboard.html.twig', [
            'title' => 'Dashboard',
            'user' => $user,
        ]);
    }

    #[Route(
        path: '/register',
        name: 'register',
        methods: ['GET', 'POST'],
    )]
    public function register (
        Request $request,
        FormHandlerService $formHandler,
        PasswordHasherService $pwdHasher,
        EntityManagerInterface $em,
    ): Response
    {
        $user = new User;
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($pwdHasher->userHashPassword($user));
            $em->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('login/register.html.twig', [
            'title' => 'Inscription',
            'form' => $form,
        ]);
    }
}
