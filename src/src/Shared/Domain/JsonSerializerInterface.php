<?php
declare(strict_types=1);
namespace KsK\Shared\Domain;

interface JsonSerializerInterface
{
  public function encode(mixed $data, array $context = []): string;
}
