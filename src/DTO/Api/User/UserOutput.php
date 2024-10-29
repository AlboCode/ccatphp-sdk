<?php

namespace Albocode\CcatphpSdk\DTO\Api\User;

class UserOutput
{
    public string $username;

    /** @var array<string, array<string>>  */
    public array $permissions;

    public string $id;
}