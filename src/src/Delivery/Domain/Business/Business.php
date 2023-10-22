<?php

namespace KsK\Delivery\Domain\Business;


use KsK\Delivery\Domain\Shared\BaseModel;
use KsK\Shared\Domain\ValueObject\Uuid;


final class Business extends BaseModel
{
  protected BusinessId $id;
  protected BusinessType $type;

  public function __construct(
    private string  $name,
    string          $type,
    private ?string $description = null,


  )
  {
    $id = Uuid::random();
    $this->id = new BusinessId($id);
    $this->type = new BusinessType($type);

  }

  public static function create(
    string $name,
    string $type,
    string $description = null,
  ): Business
  {


    $business = new self(
      $name,
      $type,
      $description,
    );

    return $business;
  }


  public function update(?string $name = null, ?string $description = null): void
  {
    $this->name = $name ?? $this->name;
    $this->description = $description ?? $this->description;

  }

  public function getId(): BusinessId
  {
    return $this->id;
  }

  public function getType(): BusinessType
  {
    return $this->type;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getDescription(): ?string
  {
    return $this->description;
  }


}
