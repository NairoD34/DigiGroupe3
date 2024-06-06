<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route(
    'admin/'
)]
class AdminController extends AbstractController
{
    #[Route(
        path: 'home',
        name: 'home',
    )]
    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access this page')]
    public function dashboardAdmin(
        Security $security,
    ) : Response
    {

        if ($user = $security->getUser() === null) {
            return $this->redirectToRoute('login');
        }

        $user = $security->getUser();

        return $this->render('admin/home.html.twig', [
            'title' => 'Dashboard Admin',
            'user' => $user,
        ]);
    }


}
