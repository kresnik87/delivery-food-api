<?php

namespace KsK\Shared\Domain\Exception;


use Exception;
use KsK\Shared\Domain\ValueObject\EmailVO;

final class EmailIsNotValid extends Exception
{
  /*** @return EmailIsNotValid */
  public static function tooLong(): self
  {
    return new self(
      sprintf(
        'Email too long. Limit is "%s" characters',
        EmailVO::MAX_LENGTH
      )
    );
  }

  /*** @return EmailIsNotValid */
  public static function withEmptyString(): self
  {
    return new self('Email is empty');
  }

  /*** @return EmailIsNotValid */
  public static function invalidFormat(): self
  {
    return new self('The email format is wrong');
  }
}
