<?php

namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;

#[Route(
    'admin/'
)]
class AdminController extends AbstractController
{
    #[Route(
        path: 'home',
        name: 'app_home',
    )]
    #[IsGranted('ROLE_ADMIN', message: 'You are not allowed to access this page')]
    public function dashboardAdmin(
        Security $security,
        Client $client,
        ClientRepository $clientRepo,
        Request $request

    ): Response {

        if ($user = $security->getUser() === null) {
            return $this->redirectToRoute('login');
        }

        $user = $security->getUser();
        $client = $clientRepo->searchByName($request->query->get('company', ''));

        return $this->render('admin/home.html.twig', [
            'title' => 'Dashboard Admin',
            'user' => $user,
            'clients' => $client
        ]);
    }
}
