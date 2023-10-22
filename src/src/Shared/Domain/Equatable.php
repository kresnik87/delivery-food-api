<?php
declare(strict_types=1);
namespace KsK\Shared\Domain;

interface Equatable
{
  public function equals(Equatable $other): bool;
}
