<?php

namespace App\Controller;

use App\Services\FormHandlerService;
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
        return $this->render('user/index.html.twig', [
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
    public function profile(): Response
    {
        return $this->render('user/profile.html.twig', [

        ]);
    }

    #[Route(
        path: 'editUser/{id}',
        name: 'editUser',
        methods: ['GET', 'POST'],
    )]
    public function editUser(
        Request $request,
        FormHandlerService $formHandler,
    )
    {

    }
}
