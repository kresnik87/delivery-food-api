<?php
declare(strict_types=1);
namespace KSK\Shared\Infrastructure\Bus\Command;

use KsK\Shared\Application\Bus\Command\CommandBusInterface;
use KsK\Shared\Application\Bus\Command\CommandInterface;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

final class SymfonyCommandBus implements CommandBusInterface
{
  use HandleTrait;

  public function __construct(MessageBusInterface $commandBus)
  {
    $this->messageBus = $commandBus;
  }

  public function dispatch(CommandInterface $command): mixed
  {
    return $this->handle($command);
  }
}