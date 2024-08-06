<?php
namespace App\Controller;

use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AdminClientFormType;

#[Route('admin/')]
class AdminClientController extends AbstractController
{
    #[Route('produit', name: 'app_client')]
    public function index(ClientRepository $clientRepo): Response
    {
        $clients = $clientRepo->searchNew();
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
            'produits' => $clients
        ]);
    }
    #[Route('new_client', name: 'app_new_client')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        Security $security,
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        $client = new Client();
        $form = $this->createForm(AdminClientFormType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            
            
            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute('app_client_list_admin');
        }
        return $this->render('admin/client_new.html.twig', [
            'title' => 'Création d\'un nouveau client',
            'form' => $form->createView(),
        ]);
    }

    #[Route('client_list', name: 'app_client_list_admin')]
    public function list(
        ClientRepository $clientRepo,
        Security $security,
        ?Client $client,
        Request $request
    ): Response {

        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }

        $client = $clientRepo->searchByName($request->query->get('company', ''));

        return $this->render('admin/client_list.html.twig', [
            'title' => 'Liste des clients',
            'client' => $client,
            'company' => $request->query->get('company', ''),
        ]);
    }

    #[Route('client_show/{id}', name: 'app_client_show_admin')]
    public function showProducts(
        ?Client $client,
        Security $security,
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }

        return $this->render('admin/client_show_admin.html.twig', [
            'title' => 'Fiche d\'un client',
            'client' => $client,
        ]);
    }

    #[Route('update_client/{id}', name: 'app_update_client')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Client $client,
        Security $security,
    ) {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($client === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(AdminClientFormType::class, $client);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($client);
            $em->flush();
            return $this->redirectToRoute('app_client_list_admin');
           
            
        }
        return $this->render('admin/client_new.html.twig', [
            'title' => 'Mise à jour d\'un client',
            'form' => $form->createView(),
        ]);
    }

    #[Route('delete_client/{id}', name: 'app_delete_client', methods: ['POST'])]
    public function delete(
        Client $client,
        Security $security,
        EntityManagerInterface $em
    ): Response {
        if (!$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_index');
        }
        if ($client === null) {
            return $this->redirectToRoute('app_admin_dashboard');
        }
        
            $em->remove($client);
            $em->flush();
            return $this->redirectToRoute('app_client_list_admin');
        }
}