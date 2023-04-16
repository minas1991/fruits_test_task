<?php

declare(strict_types=1);

namespace App\Filter;

use ApiPlatform\Doctrine\Orm\Filter\AbstractFilter;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use Doctrine\ORM\QueryBuilder;

final class FruitFilter extends AbstractFilter
{
    /**
     * @param string $resourceClass
     * @return array
     */
    public function getDescription(string $resourceClass): array
    {
        if (!$this->properties) {
            return [];
        }

        $description = [];
        foreach ($this->properties as $property => $strategy) {
            $description["$property"] = [
                'property' => $property,
                'type' => 'string',
                'required' => false,
            ];
        }

        return $description;
    }

    /**
     * @param string $property
     * @param $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @param string $resourceClass
     * @param Operation|null $operation
     * @param array $context
     * @return void
     */
    protected function filterProperty(
        string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator,
        string $resourceClass, Operation $operation = null, array $context = []): void
    {
        if (
            !$this->isPropertyEnabled($property, $resourceClass) ||
            !$this->isPropertyMapped($property, $resourceClass)
        ) {
            return;
        }

        $filter = $this->getProperties()[$property] ?? 'exact';
        $method = $filter . 'Filter';
        if (!method_exists($this, $method)) {
            return;
        }

        $this->{$method}($property, $value, $queryBuilder, $queryNameGenerator);
    }

    /**
     * @param string $property
     * @param $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @return void
     */
    private function exactFilter(
        string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator
    ): void
    {
        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->andWhere(sprintf('o.%s = :%s', $property, $parameterName))
            ->setParameter($parameterName, $value);
    }

    /**
     * @param string $property
     * @param $value
     * @param QueryBuilder $queryBuilder
     * @param QueryNameGeneratorInterface $queryNameGenerator
     * @return void
     */
    private function partialFilter(
        string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator
    ): void
    {
        $parameterName = $queryNameGenerator->generateParameterName($property);

        $queryBuilder
            ->andWhere(sprintf('o.%s LIKE :%s', $property, $parameterName))
            ->setParameter($parameterName, '%' . $value . '%');
    }
}
