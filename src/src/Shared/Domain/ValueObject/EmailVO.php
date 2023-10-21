<?php

namespace KsK\Shared\Domain\ValueObject;

class EmailVO
{
  public const MAX_LENGTH = 10;
  protected $value;

  public function __construct($value)
  {
    if (!is_null($value)) {
      $this->validate($value);
    }
    $this->value = $value;

  }

  /**
   * @return mixed
   */
  public function getValue()
  {
    return $this->value;
  }

  /*** @throws EmailIsNotValid */
  private static function validate(string $email): void
  {
    if ($email === '') {
      throw EmailIsNotValid::withEmptyString();
    }
    if (!filter_var( $email,FILTER_VALIDATE_EMAIL)) {
      throw EmailIsNotValid::invalidFormat();
    }
  }

  /**
   * @return EmailVO
   *
   * @throws EmailIsNotValid
   */
  public static function fromString(string $email): self
  {

    self::validate($email);

    return new self(
      $email
    );
  }

  /*** @throws EmailIsNotValid */
  public static function fromStringOrNull(?string $email): ?self
  {
    if ($email === null) {
      return null;
    }

    self::validate($email);

    return new self(
      $email
    );
  }

  public function asString(): ?string
  {
    return $this->value;
  }
}
