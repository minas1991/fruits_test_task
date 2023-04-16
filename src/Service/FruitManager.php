<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Fruit;
use App\Entity\Nutrition;
use App\Repository\FruitRepository;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FruitManager implements FruitManagerInterface
{
    public function __construct(
        private readonly FruitRepository $fruitRepository,
        private readonly int $favoritesLimit
    )
    {
    }

    /**
     * @param int $id
     * @param bool $fail
     * @return Fruit|null
     */
    public function find(int $id, bool $fail = true): ?Fruit
    {
        $fruit = $this->fruitRepository->find($id);
        if (!$fruit && $fail) {
            throw new HttpException(404);
        }
        return $fruit;
    }

    /**
     * @return Fruit[]
     */
    public function findAllFavorites(): array
    {
        return $this->fruitRepository->getIsFavoriteFruits();
    }

    /**
     * @param int $id
     * @return Fruit
     */
    public function addToFavorite(int $id): Fruit
    {
        $fruit = $this->find($id);
        if (!$fruit->getIsFavorite()) {
            if ($this->fruitRepository->getFavoritesCount() >= $this->favoritesLimit) {
                throw new HttpException(400);
            }

            $fruit->setIsFavorite(true);
            $this->fruitRepository->save($fruit, true);
        }

        return $fruit;
    }

    /**
     * @param int $id
     * @return Fruit
     */
    public function removeFavorite(int $id): Fruit
    {
        $fruit = $this->find($id);
        if ($fruit->getIsFavorite()) {
            $fruit->setIsFavorite(false);
            $this->fruitRepository->save($fruit, true);
        }

        return $fruit;
    }

    /**
     * @param $data
     * @return Fruit
     */
    public function createFruit($data): Fruit
    {
        $fruit = new Fruit();
        $fruit->setName($data['name']);
        $fruit->setOrder($data['order'] ?? null);
        $fruit->setGenus($data['genus'] ?? null);
        $fruit->setFamily($data['family'] ?? null);
        $nutrition = $this->createNutrition($data['nutritions'] ?? null);
        $fruit->setNutrition($nutrition);
        $this->fruitRepository->save($fruit, true);

        return $fruit;
    }

    /**
     * @param array $data
     * @return void
     */
    public function createManyFruits(array $data): void
    {
        foreach ($data as $row) {
            $this->createFruit($row);
        }
    }

    /**
     * @param array|null $data
     * @return Nutrition|null
     */
    public function createNutrition(?array $data): ?Nutrition
    {
        if (empty($data)) {
            return null;
        }

        $nutrition = new Nutrition();
        $nutrition->setCalories($data['calories'] ?? null);
        $nutrition->setFat($data['fat'] ?? null);
        $nutrition->setSugar($data['sugar'] ?? null);
        $nutrition->setCarbohydrates($data['carbohydrates'] ?? null);
        $nutrition->setProtein($data['protein'] ?? null);

        return $nutrition;
    }

    /**
     * @return Fruit[]
     */
    public function getAllFamilies(): array
    {
        $fruitsWithFamilies = $this->fruitRepository->getFamilies();
        if (empty($fruitsWithFamilies)) {
            return [];
        }

        return array_column($fruitsWithFamilies, 'family');
    }
}
