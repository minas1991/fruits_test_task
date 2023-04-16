<?php

declare(strict_types=1);

namespace App\ApiResource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\Nutrition;
use App\Controller\FruitApiController;
use App\State\FavoritesStateProvider;

#[ApiResource(
    operations: [
        new GetCollection(uriTemplate: '/fruits/all/favorites', paginationEnabled: false),
        new Post(uriTemplate: '/fruits/{id}/favorites', controller: FruitApiController::class, name: 'favorites_add'),
        new Delete(uriTemplate: '/fruits/{id}/favorites', controller: FruitApiController::class, name: 'favorites_delete')
    ],
    provider: FavoritesStateProvider::class
)]
class FavoriteFruits
{
    /**
     * @var int|null
     */
    public ?int $id = null;

    /**
     * @var string|null
     */
    public ?string $name = null;

    /**
     * @var string|null
     */
    public ?string $genus = null;

    /**
     * @var string|null
     */
    public ?string $order = null;

    /**
     * @var string|null
     */
    public ?string $family = null;

    /**
     * @var Nutrition|null
     */
    public ?Nutrition $nutrition = null;

    /**
     * @var bool|null
     */
    public ?bool $isFavorite = false;
}
