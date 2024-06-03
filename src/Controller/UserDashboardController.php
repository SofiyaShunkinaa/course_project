<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ItemCollectionRepository;
use App\Repository\UserRepository;

class UserDashboardController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(ItemCollectionRepository $itemCollectionRepository, Request $request, UserRepository $userRepository): Response
    {
        $user = $this->getUser();
        $collections = $itemCollectionRepository->findBy(['user' => $user]);

        if ($user && $user->hasRole('ROLE_ADMIN')) {
            $collections = $itemCollectionRepository->findAll();
        }

        $page = $request->query->getInt('page', 1);
        $itemsPerPage = 10;
        $totalCollections = count($collections);
        $totalPages = ceil($totalCollections / $itemsPerPage);

        $users = $userRepository->findAll();

        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'UserDashboardController',
            'collections' => $collections,
            'currentPage' => $page,
            'itemsPerPage' => $itemsPerPage,
            'totalPages' => $totalPages,
            'users' => $users,
        ]);
    }
}
