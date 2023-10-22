<?php
declare(strict_types=1);
namespace KsK\Shared\Domain;

interface Hashable
{
  public function getHash(): string;
}
