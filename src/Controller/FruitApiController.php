<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\FruitManagerInterface;

class FruitApiController extends AbstractController
{
    public function __construct(private readonly FruitManagerInterface $fruitManager)
    {
    }

    #[Route('/api/fruits/{id}/favorites', name: 'favorites_add', methods: 'POST')]
    public function addFavorite(int $id): JsonResponse
    {
        return $this->json($this->fruitManager->addToFavorite($id), 201);
    }

    #[Route('/api/fruits/{id}/favorites', name: 'favorites_delete', methods: 'DELETE')]
    public function removeFavorite(int $id): JsonResponse
    {
        return $this->json($this->fruitManager->removeFavorite($id), 204);
    }

    #[Route('/api/families', name: 'get_families', methods: 'GET')]
    public function getAllFamilies(): JsonResponse
    {
        return $this->json($this->fruitManager->getAllFamilies());
    }
}
