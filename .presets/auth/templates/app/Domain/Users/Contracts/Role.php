<?php

namespace Domain\Users\Contracts;

interface Role
{
    /**
     * Find a role by its name.
     *
     * @throws \Domain\Users\Exceptions\RoleDoesNotExistException
     *
     * @return \Domain\Users\Contracts\Role
     */
    public static function findByName(string $name): self;

    /**
     * Find a role by its id.
     *
     * @throws \Domain\Users\Exceptions\RoleDoesNotExistException
     *
     * @return \Domain\Users\Contracts\Role
     */
    public static function findById(int $id): self;

    /**
     * Find or create a role by its name.
     *
     * @return \Domain\Users\Contracts\Role
     */
    public static function findOrCreate(string $name): self;
}
