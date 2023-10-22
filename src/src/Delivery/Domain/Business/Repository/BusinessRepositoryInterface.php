<?php

namespace KsK\Delivery\Domain\Business\Repository;

use KsK\Delivery\Domain\Business\Business;
use KsK\Delivery\Domain\Business\BusinessId;
use KsK\Shared\Domain\Criteria\Criteria;
use KsK\Shared\Domain\Repository\RepositoryInterface;

interface BusinessRepositoryInterface extends RepositoryInterface
{
  public function save(Business $business): Business;

  public function add(Business $business, bool $flush): Business;

  public function findOrFail(BusinessId $businessId): ?Business;

  public function remove(Business $business, bool $flush);

  public function searchByCriteria(Criteria $criteria): static;
}
