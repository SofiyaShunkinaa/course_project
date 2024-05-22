<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CollectionType;
use App\Entity\ItemCollection;
use App\Controller\EntityManagerInterface;

class CollectionController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ){

    }

    #[Route('/collections', name: 'app_collection')]
    public function index(): Response
    {
        return $this->render('collection/index.html.twig', [
            'controller_name' => 'CollectionController',
        ]);
    }

    #[Route('/collections/create', name: 'app_collection_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function сreate(Request $request): Response
    {
        $collection = new ItemCollection();
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->entityManager->persist($collection);
            $this->entityManager->flush();

            $this->addFlush('success', "Collection successfully created!");
        }

        return $this->render('collection/form.html.twig', [
            'action' => 'create',
            'form' => $form,
        ]);
    }
}
