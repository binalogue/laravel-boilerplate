<?php

namespace Tests\Factories;

use Domain\Users\DataTransferObjects\UserData;

final class UserFactory
{
    public string $name;
    public string $first_surname;
    public string $email;

    public static function new(): self
    {
        return new self;
    }

    public function create(array $extra = []): UserData
    {
        return new UserData(array_merge(
            [
                'name' => 'Pepito',
                'first_surname' => 'Grillo',
                'email' => 'pepito@grillo.com',
            ],
            $extra
        ));
    }
}
