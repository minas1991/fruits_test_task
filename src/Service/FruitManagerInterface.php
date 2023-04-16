<?php

declare(strict_types=1);

namespace App\Service;
use App\Entity\Fruit;

interface FruitManagerInterface
{
    /**
     * @param array $data
     * @return Fruit
     */
    public function createFruit(array $data): Fruit;
}
