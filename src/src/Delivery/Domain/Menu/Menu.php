<?php

namespace KsK\Delivery\Domain\Menu;


use KsK\Delivery\Domain\Business\BusinessId;
use KsK\Delivery\Domain\Shared\BaseModel;
use KsK\Shared\Domain\ValueObject\Uuid;


final class Menu extends BaseModel
{
  protected MenuId $id;

  public function __construct(
    private string  $name,
    private ?string $description = null,


  )
  {
    $id = Uuid::random();
    $this->id = new MenuId($id);

  }

  public static function create(
    string $name,
    string $description = null,
  ): Menu
  {


    $menu = new self(
      $name,
      $description,
    );

    return $menu;
  }


  public function update(?string $name = null, ?string $description = null): void
  {
    $this->name = $name ?? $this->name;
    $this->description = $description ?? $this->description;

  }

  public function getId(): MenuId
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


}
