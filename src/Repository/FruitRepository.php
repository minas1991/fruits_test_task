<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Fruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Fruit>
 *
 * @method Fruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Fruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Fruit[]    findAll()
 * @method Fruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FruitRepository extends ServiceEntityRepository
{
    /**
     * Is Favorite field name
     */
    private const FIELD_IS_FAVORITE = 'isFavorite';

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Fruit::class);
    }

    /**
     * @param Fruit $entity
     * @param bool $flush
     * @return void
     */
    public function save(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param Fruit $entity
     * @param bool $flush
     * @return void
     */
    public function remove(Fruit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return int
     */
    public function getFavoritesCount(): int
    {
        return $this->count([self::FIELD_IS_FAVORITE => true]);
    }

    /**
     * @return Fruit[]
     */
    public function getIsFavoriteFruits(): array
    {
        return $this->findBy([self::FIELD_IS_FAVORITE => true]);
    }

    /**
     * @return Fruit[]
     */
    public function getFamilies(): array
    {
        return $this->createQueryBuilder('f')
            ->select('DISTINCT f.family')
            ->getQuery()
            ->getResult();
    }
}
