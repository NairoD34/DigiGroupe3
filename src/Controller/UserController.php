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

#[Route(
    'user/'
)]
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/projects.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route(
        path: 'dashboard',
        name: 'dashboard',
        methods: ['GET'],
    )]
    public function dashboard(
        Security $security,
    ): Response
    {
        if ( $user = $security->getUser() === null ) {
            return $this->redirectToRoute('login');
        }
        $user = $security->getUser();
        return $this->render('user/dashboard.html.twig', [
            'title' => 'Dashboard',
            'user' => $user,
        ]);
    }

    #[Route(
        path: 'profile',
        name: 'profile',
        methods: ['GET'],
    )]
    public function profile(
        Security $security,
    ): Response
    {
        $user = $security->getUser();
        if ( $user === null ) {
            return $this->redirectToRoute('/');
        }
        return $this->render('user/profile.html.twig', [
            'title' => 'Mon profil',
            'user' => $user,
        ]);
    }

    #[Route(
        path: 'editProfile/{id}',
        name: 'editProfile',
        methods: ['GET', 'POST'],
    )]
    public function editProfile(
        Request $request,
        FormHandlerService $formHandler,
        Security $security,
        User $entity,
        EntityManagerInterface $em,
        PasswordHasherService $passwordHasher,
    ) : Response
    {
        $user = $security->getUser();
        if ($user === null ){
            return $this->redirectToRoute('/');
        }
        // TODO : Revoir comment utiliser un service pour hash le mdp
        $form = $this->createForm(UserFormType::class, $user);
        if ($formHandler->handleForm($form, $request, true)){
            return $this->redirectToRoute('profile');
        }
        //$form = $this->createForm(UserFormType::class, $user, ['user' => $user]);
        //$form->handleRequest($request);
        //if ($form->isSubmitted() && $form->isValid()) {
        //    $em->persist($passwordHasher->userHashPassword($user));
        //    $em->flush();
        //    return $this->redirectToRoute('profile');
        //}
        return $this->render('login/register.html.twig', [
            'title' => 'Mettre à jour son profil',
            'form' => $form,
        ]);

    }
}
