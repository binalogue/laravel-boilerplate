<?php

namespace Tests\Domain\Users\Actions;

use Domain\Users\Actions\CreateUserAction;
use Domain\Users\DataTransferObjects\UserData;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

/** @see \Domain\Users\Actions\CreateUserAction */
class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;

    protected CreateUserAction $createUserAction;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createUserAction = new CreateUserAction();
    }

    /** @test */
    public function can_create_a_user()
    {
        Carbon::setTestNow(
            Carbon::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:23:45')
        );

        $this->createUserAction->execute(
            UserData::new([
                'first_name' => 'Pepe',
                'last_name' => 'Grillo',
                'email' => 'pepe@example.com',
                'password' => 'awesome-secret',
            ])
        );

        $this->assertDatabaseHas('users', [
            'first_name' => 'pepe',
            'last_name' => 'grillo',
            'email' => 'pepe@example.com',
            'email_verified_at' => null,
            'password_changed_at' => '2020-01-01 01:23:45',
        ]);
    }
}
