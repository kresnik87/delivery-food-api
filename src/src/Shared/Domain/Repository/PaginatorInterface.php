<?php

namespace KsK\Shared\Domain\Repository;

/**
 * @template T of object
 *
 * @extends \IteratorAggregate<T>
 */
interface PaginatorInterface extends \IteratorAggregate, \Countable
{
  public function getCurrentPage(): int;

  public function getItemsPerPage(): int;

  public function getLastPage(): int;

  public function getTotalItems(): int;
}
