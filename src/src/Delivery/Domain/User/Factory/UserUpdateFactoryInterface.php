<?php

namespace KsK\Delivery\Domain\User\Factory;

use KsK\Delivery\Domain\User\User;

interface UserUpdateFactoryInterface
{
       public function update(User $user,?string $name, ?string $lastName):User;
}
