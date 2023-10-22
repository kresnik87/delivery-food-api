<?php

namespace KsK\Delivery\Domain\Place;


final class Restaurant extends Place
{

  public function __construct(string $name, ?string $description = null)
  {
    parent::__construct($name, $description);
  }

  public static function create(string $name, string $description): self
  {
    return new self($name, $description);
  }


  public function checkPlace(object $entity): bool
  {
    return ($entity instanceof Restaurant::class);
  }
}
