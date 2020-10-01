<?php

namespace Domain\Users\Contracts;

interface Role
{
    /**
     * Find a role by its name.
     *
     * @param string $name
     *
     * @return \Domain\Users\Contracts\Role
     *
     * @throws \Domain\Users\Exceptions\RoleDoesNotExistException
     */
    public static function findByName(string $name): self;

    /**
     * Find a role by its id.
     *
     * @param int $id
     *
     * @return \Domain\Users\Contracts\Role
     *
     * @throws \Domain\Users\Exceptions\RoleDoesNotExistException
     */
    public static function findById(int $id): self;

    /**
     * Find or create a role by its name.
     *
     * @param string $name
     *
     * @return \Domain\Users\Contracts\Role
     */
    public static function findOrCreate(string $name): self;
}
