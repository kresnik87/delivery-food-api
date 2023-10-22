<?php

namespace KsK\Delivery\Domain\User;


use KsK\Shared\Domain\ValueObject\Enum;

class Role extends Enum
{
    const ROLE_SUPER_ADMIN='ROLE_ADMIN';
    const ROLE_RIDER='ROLE_RIDER';
    const ROLE_BUSINESS='ROLE_BUSINESS';
    const ROLE_USER='ROLE_USER';


}
