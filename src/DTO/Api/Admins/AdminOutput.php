<?php

namespace Albocode\CcatphpSdk\DTO\Api\Admins;

class AdminOutput
{
    public string $username;

    /** @var array<string, array<string>>  */
    public array $permissions;

    public string $id;
}