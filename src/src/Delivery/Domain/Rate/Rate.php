<?php
declare(strict_types=1);
namespace KsK\Delivery\Domain\Rate;


use KsK\Delivery\Domain\Shared\BaseModel;
use KsK\Shared\Domain\ValueObject\Uuid;


final class Rate extends BaseModel
{
  protected RateId $id;
  protected RateType $type;

  public function __construct(
    private string  $name,
    string          $type,
    private ?string $description = null,
    private ?float  $price = null,
    private ?int    $maxPlaces = 0,
    private ?int    $daysFree = 7,


  )
  {
    $id = Uuid::random();
    $this->id = new RateId($id->value());
    $this->type = new RateType($type);


  }

  public static function create(
    string $name,
    string $type,
    string $description = null,
    ?float $price = null,
    ?int   $maxPlaces = null,
    ?int   $daysFree = null,
  ): Rate
  {


    $rate = new self(
      $name,
      $type,
      $description,
      $price,
      $maxPlaces,
      $daysFree
    );

    return $rate;
  }


  public function update(?string $name = null, ?string $description = null): void
  {
    $this->name = $name ?? $this->name;
    $this->description = $description ?? $this->description;

  }

  public function getId(): RateId
  {
    return $this->id;
  }

  public function getType(): RateType
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

  public function getPrice(): ?float
  {
    return $this->price;
  }

  public function getMaxPlaces(): ?int
  {
    return $this->maxPlaces;
  }

  public function getDaysFree(): ?int
  {
    return $this->daysFree;
  }




}
