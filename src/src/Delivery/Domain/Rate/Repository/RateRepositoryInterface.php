<?php

namespace KsK\Delivery\Domain\Rate\Repository;

use KsK\Delivery\Domain\Rate\Rate;
use KsK\Delivery\Domain\Rate\RateId;
use KsK\Shared\Domain\Criteria\Criteria;
use KsK\Shared\Domain\Repository\RepositoryInterface;

interface RateRepositoryInterface extends RepositoryInterface
{
  public function save(Rate $rate): Rate;

  public function add(Rate $rate, bool $flush): Rate;

  public function findOrFail(RateId $rateId): ?Rate;

  public function remove(Rate $rate, bool $flush);

  public function searchByCriteria(Criteria $criteria): static;
}
