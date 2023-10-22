<?php

namespace KsK\Delivery\Domain\User\Factory;

use KsK\Delivery\Domain\User\User;

interface UserCreateFactoryInterface
{
    public function singUp(string $email, string $userName, string $password, string $name, bool $isAdmin): User;

    public function create(string $email, string $userName, ?string $password, string $name, string $lastName): User;
}
