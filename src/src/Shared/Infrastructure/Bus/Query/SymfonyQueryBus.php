<?php

namespace KSK\Shared\Infrastructure\Bus\Query;

use KsK\Shared\Application\Bus\Query\QueryBusInterface;
use KsK\Shared\Application\Bus\Query\QueryInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyQueryBus implements QueryBusInterface
{
  use HandleTrait;

  public function __construct(MessageBusInterface $queryBus)
  {
    $this->messageBus = $queryBus;
  }

  public function ask(QueryInterface $query): mixed
  {
    return $this->handle($query);
  }
}
