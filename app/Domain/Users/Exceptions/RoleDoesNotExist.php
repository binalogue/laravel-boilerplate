<?php

namespace Domain\Users\Exceptions;

use InvalidArgumentException;

class RoleDoesNotExist extends InvalidArgumentException
{
    public static function named(string $roleName)
    {
        return new static("No hay ningún rol llamado `{$roleName}`.");
    }

    public static function withId(int $roleId)
    {
        return new static("No hay ningún rol con ID `{$roleId}`.");
    }
}
