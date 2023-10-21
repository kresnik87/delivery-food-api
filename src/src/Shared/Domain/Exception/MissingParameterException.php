<?php
declare(strict_types=1);
namespace KsK\Shared\Domain\Exception;

use Throwable;

class MissingParameterException extends \Exception
{
  const DEFAULT_MESSAGE = 'Missing Parameter Exception';
  const DEFAULT_CODE = 406;

  public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
  {
    $message = !empty($message) ? $message : self::DEFAULT_MESSAGE;
    $code = !empty($code) ? $code : self::DEFAULT_CODE;
    parent::__construct($message, $code, $previous);
  }
}
