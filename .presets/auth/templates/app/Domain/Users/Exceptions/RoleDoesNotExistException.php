<?php

namespace Domain\Users\Exceptions;

use InvalidArgumentException;

class RoleDoesNotExistException extends InvalidArgumentException
{
    public static function named(string $roleName): self
    {
        return new static("No hay ningún rol llamado `{$roleName}`.");
    }

    public static function withId(int $roleId): self
    {
        return new static("No hay ningún rol con ID `{$roleId}`.");
    }
}
