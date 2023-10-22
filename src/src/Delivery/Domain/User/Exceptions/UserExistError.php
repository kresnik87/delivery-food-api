<?php

declare(strict_types=1);

namespace KsK\Delivery\Domain\User\Exceptions;

use KsK\Shared\Domain\DomainError;

final class UserExistError extends DomainError
{
    public function __construct(private readonly string $email)
    {
        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'email_exist';
    }

    protected function errorMessage(): string
    {
        return sprintf('The email <%s>  exist', $this->email);
    }
}
