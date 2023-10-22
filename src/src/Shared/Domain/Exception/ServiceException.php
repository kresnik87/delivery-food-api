<?php

namespace KsK\Shared\Domain\Exception;

use Throwable;

class ServiceException extends \Exception
{
  const DEFAULT_MESSAGE = 'Service Exception';
  const DEFAULT_CODE = 400;

  public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
  {
    $message = !empty($message) ? $message : self::DEFAULT_MESSAGE;
    $code = !empty($code) ? $code : self::DEFAULT_CODE;
    parent::__construct($message, $code, $previous);
  }
}
