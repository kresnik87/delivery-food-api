<?php

namespace KsK\Delivery\Domain\User\Factory;

use KsK\Delivery\Domain\User\User;

class UserUpdateFactory implements UserUpdateFactoryInterface
{

    public function update(User $user, ?string $name, ?string $lastName): User
    {
        $user->update(
            name: $name,
            lastname: $lastName,
        );
        return $user;
    }
}
