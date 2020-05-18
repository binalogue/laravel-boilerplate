<?php

namespace Tests\Domain\Users\Actions;

use Domain\Users\Actions\CreateUserAction;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Spatie\QueueableAction\ActionJob;
use Tests\Factories\UserFactory;
use Tests\TestCase;

class CreateUserActionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_a_user()
    {
        Queue::fake();

        $data = UserFactory::new()->create([
            'email' => 'pepito@grillo.com',
        ]);

        (new CreateUserAction($this->sendSalesforceUsersFormAction))
            ->execute($data);

        $this->assertNotNull(
            User::where('email', 'pepito@grillo.com')->firstOrFail()
        );
    }
}
