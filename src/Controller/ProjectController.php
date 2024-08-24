<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\StateOfProject;
use App\Form\ProjectFormType;
use App\Form\StateOfProjectFormType;
use App\Repository\ProjectRepository;
use App\Repository\StateOfProjectRepository;
use App\Services\FormHandlerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('project')]
class ProjectController extends AbstractController
{
    #[Route(
        path: '/',
        name: 'viewProjects',
        methods: ['GET'],
    )]
    public function viewProjects(
        ProjectRepository $projectRepository,
    ): Response
    {
        $projects = $projectRepository->findAll();
        return $this->render('project/projects.html.twig', [
            'title' => 'Tout les projets',
            'projects' => $projects,
        ]);
    }

    #[Route(
        path: '/viewProject/{id}',
        name: 'viewProject',
        methods: ['GET'],
    )]
    public function viewProject(
        Project $project,
        ProjectRepository $projectRepository,
    ) :Response
    {
        $project = $projectRepository->find($project->getId());
        return $this->render('project/project.html.twig', [
            'title' => $project->getName(),
            'project' => $project,
        ]);
    }

    #[Route(
        path: '/addProject',
        name: 'addProject',
        methods: ['GET','POST']
    )]
    public function addProject(
        Request $request,
        EntityManagerInterface $em,
        Security $security,
        FormHandlerService $formHandler,
    ): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectFormType::class, $project);
        if ($formHandler->handleForm($form, $request, true)){
            return $this->redirectToRoute('viewProjects');
        }
        return $this->render('project/_form.html.twig', [
            'title' => 'Ajout d\'un projet',
            'form' => $form,
        ]);
    }

    #[Route(
        path: '/editProject/{id}',
        name: 'editProject',
        methods: ['GET', 'POST']
    )]
    public function editProject(
        ?Project $project,
        Request $request,
        Security $security,
        FormHandlerService $formHandler,
    ): Response
    {
        if (!$project){
            $this->addFlash('warning', 'Projet introuvable');
            return $this->redirectToRoute('viewProjects');
        }
        $form = $this->createForm(ProjectFormType::class, $project);
        if ($formHandler->handleForm($form, $request, true)){
            return $this->redirectToRoute('viewProject', ['id' => $project->getId()]);
        }
        return $this->render('project/_form.html.twig', [
            'title' => 'Edition d\'un projet',
            'form' => $form,
        ]);
    }

    #[Route(
        path:'/deleteProject/{id}',
        name: 'deleteProject',
    )]
    public function deleteProject(
        ?Project $project,
        Request $request,
        Security $security,
        FormHandlerService $formHandler,
        EntityManagerInterface $em,
    ): Response
    {
        if (!$project){
            $this->addFlash('warning', 'Projet introuvable');
            return $this->redirectToRoute('viewProjects');
        }
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('viewProjects');
    }

    #[Route('/viewStatesProject', name: 'viewStatesProject', methods: ['GET'])]
    public function viewStatesProject(
        StateOfProject $stateOfProject,
        StateOfProjectRepository $stateOfProjectRepository,
    ): Response
    {
        $states = $stateOfProjectRepository->findAll();
        return $this->render('project/_states_project.html.twig', [
            'title' => 'Tout les états de projet',
            'states' => $states,
        ]);
    }

    #[Route('/addStateProject', name: 'addStateProject', methods: ['GET', 'POST'])]
    public function addStateProject(
        Request $request,
        Security $security,
        FormHandlerService $formHandler,
    ): Response
    {
        $state = new StateOfProject();
        $form = $this->createForm(StateOfProjectFormType::class, $state);
        if ($formHandler->handleForm($form, $request, true)){
            return $this->redirectToRoute('viewStatesProject');
        }
        return $this->render('project/_state_form.html.twig', [
            'title' => 'Ajout d\'un état de projet',
            'form' => $form,
        ]);
    }
    #[Route('/editStateProject/{id}', name: 'editStateProject', methods: ['GET', 'POST'])]
    public function editStateProject(
        ?StateOfProject $stateOfProject,
        Request $request,
        Security $security,
        FormHandlerService $formHandler,
        EntityManagerInterface $em,
    ): Response
    {
        if (!$stateOfProject){
            $this->addFlash('warning', 'État introuvable');
            return $this->redirectToRoute('viewStatesProject');
        }
        $form = $this->createForm(StateOfProjectFormType::class, $stateOfProject);
        if ($formHandler->handleForm($form, $request, true)){
            return $this->redirectToRoute('viewStatesProject');
        }
        return $this->render('project/_state_form.html.twig', [
            'title' => 'Edition d\'un état de projet',
            'form' => $form,
        ]);
    }

    #[Route('/deleteStateProject/{id}', name: 'deleteStateProject', methods: ['GET'])]
    public function deleteStateProject(
        ?StateOfProject $stateOfProject,
        EntityManagerInterface $em,
    ): Response
    {
        if (!$stateOfProject){
            $this->addFlash('warning', 'État introuvable');
            return $this->redirectToRoute('viewProjects');
        }
        $em->remove($stateOfProject);
        $em->flush();
        return $this->redirectToRoute('viewStatesProject');
    }


}
