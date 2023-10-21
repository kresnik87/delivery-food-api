<?php
declare(strict_types=1);
namespace KsK\Shared\Application\Bus\Query;


interface QueryBusInterface
{
  public function ask(QueryInterface $query): mixed;
}
