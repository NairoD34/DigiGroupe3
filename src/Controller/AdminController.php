<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Project;
use App\Entity\User;
use App\Repository\ClientRepository;
use App\Repository\ProjectRepository;
use App\Repository\UserRepository;
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
        Project $project,
        User $users,
        ProjectRepository $projectRepo,
        UserRepository $userRepo,
        Request $request

    ) : Response
    {

        if ($user = $security->getUser() === null) {
            return $this->redirectToRoute('login');
        }

        $user = $security->getUser();
        $client = $clientRepo->searchByName($request->query->get('company', ''));
        $project = $projectRepo->searchByName($request->query->get('name', ''));
        $users = $userRepo->searchByName($request->query->get('lastName', ''));

        return $this->render('admin/home.html.twig', [
            'title' => 'Dashboard Admin',
            'user' => $user,
            'clients' =>$client,
            'projects' => $project,
            'users' => $users,
        ]);
    }


}
