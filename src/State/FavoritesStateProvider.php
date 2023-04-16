<?php

namespace App\State;

use App\Service\FruitManagerInterface;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use ApiPlatform\Metadata\CollectionOperationInterface;

class FavoritesStateProvider implements ProviderInterface
{
    public function __construct(private readonly FruitManagerInterface $fruitManager)
    {
    }

    /**
     * @param Operation $operation
     * @param array $uriVariables
     * @param array $context
     * @return object|array|null
     */
    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        if ($operation instanceof CollectionOperationInterface) {
            return $this->fruitManager->findAllFavorites();
        }

        return $this->fruitManager->find($uriVariables['id']);
    }
}
