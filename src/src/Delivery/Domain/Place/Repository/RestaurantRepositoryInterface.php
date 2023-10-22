<?php

namespace KsK\Delivery\Domain\Business\Repository;

use KsK\Delivery\Domain\Place\PlaceId;
use KsK\Delivery\Domain\Place\Restaurant;
use KsK\Shared\Domain\Criteria\Criteria;
use KsK\Shared\Domain\Repository\RepositoryInterface;

interface RestaurantRepositoryInterface extends RepositoryInterface
{
  public function save(Restaurant $restaurant): Restaurant;

  public function add(Restaurant $restaurant, bool $flush): Restaurant;

  public function findOrFail(PlaceId $id): ?Restaurant;

  public function remove(Restaurant $restaurant, bool $flush);

  public function searchByCriteria(Criteria $criteria): static;
}
