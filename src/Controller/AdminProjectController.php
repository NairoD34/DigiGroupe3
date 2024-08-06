<?php
namespace App\Controller;

use App\Entity\Project;
use App\Entity\StateOfProject;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdminProjectFormType;
use App\Repository\StateOfProjectRepository;
use DateTime;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Component\Validator\Constraints\Date;

#[Route('admin/')]
class AdminProjectController extends AbstractController
{
    #[Route('produit', name: 'app_project')]
    public function index(ProjectRepository $projectRepo): Response
    {
        $projects = $projectRepo->searchNew();
        return $this->render('project/index.html.twig', [
            'controller_name' => 'ProjectController',
            'produits' => $projects
        ]);
    }
    #[Route('new_project', name: 'app_new_project')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        Security $security,
        StateOfProject $stateOfProject,
        StateOfProjectRepository $stateOfProjectRepo
    ): Response {
        $currentDate = new DateTime();
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        $project = new Project();
        $form = $this->createForm(AdminProjectFormType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if(date_diff($form['startDate']->getData(),$currentDate)->format("%R%a") < 0 ){
                $stateOfProject = $stateOfProjectRepo->findOneByid(1);
            }
            else if(date_diff($form['startDate']->getData(),$currentDate)->format("%R%a") > 0  && date_diff($form['endDate']->getData(),$currentDate)->format("%R%a") < 0  ){
                $stateOfProject = $stateOfProjectRepo->findOneByid(2);
            }
            else if(date_diff($form['endDate']->getData(),$currentDate)->format("%R%a") > 0 ){
                $stateOfProject = $stateOfProjectRepo->findOneByid(3);
            }
            $project->setStateOfProject($stateOfProject);
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('app_project_list_admin');
        }
        return $this->render('admin/project_new.html.twig', [
            'title' => 'Création d\'un nouveau project',
            'form' => $form->createView(),
        ]);
    }

    #[Route('project_list', name: 'app_project_list_admin')]
    public function list(
        ProjectRepository $projectRepo,
        Security $security,
        ?Project $project,
        Request $request
    ): Response {

        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        $project = $projectRepo->searchByName($request->query->get('name', ''));
        


        return $this->render('admin/project_list.html.twig', [
            'title' => 'Liste des projects',
            'project' => $project,
        ]);
    }

    #[Route('project_show/{id}', name: 'app_project_show_admin')]
    public function showProducts(
        ?Project $project,
        Security $security,
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('admin/project_show_admin.html.twig', [
            'title' => 'Fiche d\'un project',
            'project' => $project,
        ]);
    }

    #[Route('update_project/{id}', name: 'app_update_project')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Project $project,
        Security $security,
    ) {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($project === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(AdminProjectFormType::class, $project);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($project);
            $em->flush();
            return $this->redirectToRoute('app_project_list_admin');
           
            
        }
        return $this->render('admin/project_new.html.twig', [
            'title' => 'Mise à jour d\'un project',
            'form' => $form->createView(),
        ]);
    }

    #[Route('delete_project/{id}', name: 'app_delete_project', methods: ['POST'])]
    public function delete(
        Project $project,
        Security $security,
        EntityManagerInterface $em
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($project === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }
        
            $em->remove($project);
            $em->flush();
            return $this->redirectToRoute('app_project_list_admin');
        }
}