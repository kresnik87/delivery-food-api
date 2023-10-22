<?php

namespace KsK\Delivery\Domain\User\Repository;

use KsK\Delivery\Domain\User\User;
use KsK\Delivery\Domain\User\UserId;
use KsK\Shared\Domain\Repository\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function save(User $user): User;

    public function add(User $user, bool $flush): User;

    public function findOrFail(UserId $userId): ?User;

    public function remove(User $user, bool $logical);

    public function alreadyExists(string $email): bool;

    public function onlyAdmin():static;

    public function search(string $context):static;
}
