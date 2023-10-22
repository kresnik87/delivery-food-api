<?php
declare(strict_types=1);
namespace KsK\Shared\Application\Bus\Command;

interface CommandBusInterface
{
  public function dispatch(CommandInterface $command): mixed;
}
