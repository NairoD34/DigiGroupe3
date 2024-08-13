<?php
namespace App\Controller;

use App\Entity\Project;
use App\Entity\StateOfProject;
use App\Entity\User;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdminProjectFormType;
use App\Form\AdminUserFormType;
use App\Repository\StateOfProjectRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Component\Validator\Constraints\Date;

#[Route('admin/')]
class AdminUserController extends AbstractController
{
    #[Route('user', name: 'app_user')]
    public function index(UserRepository $userRepo): Response
    {
        $users = $userRepo->searchNew();
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'users' => $users
        ]);
    }
    

    #[Route('user_list', name: 'app_user_list_admin')]
    public function list(
        UserRepository $userRepo,
        Security $security,
        ?User $user,
        Request $request
    ): Response {

        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        $user = $userRepo->searchByName($request->query->get('lastName', ''));
        


        return $this->render('admin/user_list.html.twig', [
            'title' => 'Liste des utilisateurs',
            'user' => $user,
        ]);
    }

    #[Route('user_show/{id}', name: 'app_user_show_admin')]
    public function showProducts(
        ?User $user,
        Security $security,
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('admin/user_show_admin.html.twig', [
            'title' => 'Fiche d\'un utilisateur',
            'user' => $user,
        ]);
    }

    #[Route('update_user/{id}', name: 'app_update_user')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?User $user,
        Security $security,
    ) {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($user === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(AdminUserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_user_list_admin');
           
            
        }
        return $this->render('admin/user_update.html.twig', [
            'title' => 'Mise à jour d\'un utilisateur',
            'form' => $form->createView(),
        ]);
    }

    #[Route('delete_user/{id}', name: 'app_delete_user', methods: ['POST'])]
    public function delete(
        User $user,
        Security $security,
        EntityManagerInterface $em
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($user === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }
        
            $em->remove($user);
            $em->flush();
            return $this->redirectToRoute('app_user_list_admin');
        }
}