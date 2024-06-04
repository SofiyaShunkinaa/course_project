<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\CollectionType;
use App\Entity\ItemCollection;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ItemCollectionRepository;
use App\Repository\CustomItemAttributeRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class CollectionController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/collections', name: 'app_collection')]
    public function index(): Response
    {
        return $this->render('collection/index.html.twig', [
            'controller_name' => 'CollectionController',
        ]);
    }

    #[Route('/collections/create', name: 'app_collection_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function create(Request $request): Response
    {
        $collection = new ItemCollection();
        $user = $this->getUser();
        $collection->setUser($user);
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($collection);
            $this->entityManager->flush();

            $this->addFlash('success', "Collection successfully created!");
        }

        return $this->render('collection/form.html.twig', [
            'action' => 'create',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/collections/{id}/update', name: 'app_collection_update', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function update(Request $request, ItemCollection $collection): Response
    {
        $form = $this->createForm(CollectionType::class, $collection);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash('success', "Collection successfully updated!");
        }

        return $this->render('collection/form.html.twig', [
            'action' => 'Update',
            'form' => $form->createView(),
            'collection' => $collection,
        ]);
    }

    #[Route('/collections/{id}/delete', name: 'app_collection_delete', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function delete(Request $request, ItemCollectionRepository $itemCollectionRepository, CustomItemAttributeRepository $customItemAttributeRepository, int $id)
    {
        $customItemAttributes = $customItemAttributeRepository->findBy(['itemCollection' => $id]);

        foreach ($customItemAttributes as $customItemAttribute) {
            $this->entityManager->remove($customItemAttribute);
        }

        $itemCollection = $itemCollectionRepository->findOneBy(['id' => $id]);
        $this->entityManager->remove($itemCollection);
        $this->entityManager->flush();
        return $this->redirectToRoute('app_dashboard');
    }
}
