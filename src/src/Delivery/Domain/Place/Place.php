<?php

namespace KsK\Delivery\Domain\Place;


use KsK\Delivery\Domain\Business\Business;
use KsK\Delivery\Domain\Shared\BaseModel;
use KsK\Shared\Domain\ValueObject\Uuid;


abstract class Place extends BaseModel
{
  protected PlaceId $id;
  private ?Business $business = null;

  public function __construct(
    private string  $name,
    private ?string $description = null,


  )
  {
    $id = Uuid::random();
    $this->id = new PlaceId($id);

  }


  public function getId(): PlaceId
  {
    return $this->id;
  }


  public function getName(): string
  {
    return $this->name;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function getBusiness(): ?Business
  {
    return $this->business;
  }

  public function setBusiness(?Business $business): void
  {
    $this->business = $business;
  }

  public abstract function checkPlace(object $entity): bool;


}
