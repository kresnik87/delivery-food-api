<?php

namespace KsK\Delivery\Domain\User\Factory;

use KsK\Delivery\Domain\User\User;
use KsK\Shared\Domain\Model\PasswordHasherInterface;

class UserCreateFactory implements UserCreateFactoryInterface
{
    public function __construct(private PasswordHasherInterface $passwordHasher)
    {
    }

    public function singUp(string $email, string $userName, string $password, string $name, bool $isAdmin): User
    {
        $user = User::signUp($email, $userName, $password, $name);
        if($isAdmin){
            $user->setAsAdmin();
        }
        $user->encodePassword($this->passwordHasher);
        return $user;
    }

    public function create(string $email, string $userName, ?string $password, string $name, ?string $lastName): User
    {

        $user = User::create($email, $password, $userName, $name, $lastName);
        $user->encodePassword($this->passwordHasher);
        return $user;
    }
}
