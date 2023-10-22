<?php

namespace KsK\Shared\Domain\Service;

use KsK\Shared\Domain\Aggregate\AggregateRoot;

interface PasswordHasherInterface
{
  public function hashPassword(AggregateRoot $user, string $plainPassword): string;
}
