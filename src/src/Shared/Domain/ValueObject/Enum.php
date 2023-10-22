<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\ValueObject;

class Enum implements \JsonSerializable
{
  protected string $value;

  public function __construct($value)
  {
    $this->value = $value;
    $this->validate();
  }

  /**
   * @return mixed
   */
  public function getValue()
  {
    return $this->value;
  }

  private function validate(): void
  {
    if (!in_array($this->getValue(), self::values())) {
      throw new \InvalidArgumentException(sprintf('The value <%s> is not valid', $this->getValue()));
    }
  }

  public static function values(): array
  {
    $reflection = new \ReflectionClass(static::class);
    return array_values($reflection->getConstants());
  }

  public function __toString(): string
  {
    return $this->getValue() ?: '';
  }

  public function jsonSerialize(): mixed
  {
    return $this->__toString();
  }

  public function equals(Enum $other): bool
  {
    return $other == $this;
  }
}

