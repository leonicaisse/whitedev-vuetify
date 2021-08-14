<?php

namespace App\Filter;

use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\AbstractFilter;
use Doctrine\ORM\QueryBuilder;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Util\QueryNameGeneratorInterface;

class CustomSearchFilter extends AbstractFilter
{
  protected function filterProperty(string $property, $value, QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, ?string $operationName = null)
  {
    if ($property !== 'search') {
      return;
    }

    $alias = $queryBuilder->getRootAliases()[0];
    $valueParameter = $queryNameGenerator->generateParameterName('search');
    $queryBuilder
      ->andWhere(sprintf('%s.title LIKE :%s OR %s.artist LIKE :%s', $alias, $valueParameter, $alias, $valueParameter))
      ->setParameter($valueParameter, '%' . $value . '%');
  }

  public function getDescription(string $resourceClass): array
  {
    return [
      'search' => [
        'property' => null,
        'type' => 'string',
        'required' => false,
        'description' => 'Search for this string in both title and artist fields',
        'swagger' => [
          'description' => 'Search for this string in both title and artist fields',
          'name' => 'Search',
          'type' => 'string',
        ],
      ],
    ];
  }
}
