<?php

namespace Tests\App\Platform\Auth\Controllers;

use Domain\Users\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Support\Testing\Concerns\RegistrationRoutes;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\RegisterController */
class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    use RegistrationRoutes;

    /*
    |--------------------------------------------------------------------------
    | Action: showRegisterForm
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_see_the_register_form()
    {
        $this
            ->get($this->registerGetRoute('pepe@example.com'))
            ->assertSuccessful()
            ->assertPropValue('newUser', function ($newUser) {
                $this->assertEquals('pepe@example.com', $newUser['email']);
            });
    }

    /*
    |--------------------------------------------------------------------------
    | Action: register
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function guest_can_register()
    {
        Event::fake();

        Carbon::setTestNow(
            Carbon::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:23:45')
        );

        $this
            ->from($this->registerGetRoute('pepe@example.com'))
            ->post(route('register'), [
                'first_name' => 'Pepe',
                'last_name' => 'Grillo',
                'email' => 'pepe@example.com',
                'password' => 'awesome-secret',
                'password_confirmation' => 'awesome-secret',
            ])
            ->assertRedirect($this->successfulRegistrationRoute());

        $this->assertCount(1, $users = User::all());
        $this->assertAuthenticatedAs($user = $users->first());

        $this->assertEquals('Pepe', $user->first_name);
        $this->assertEquals('Grillo', $user->last_name);
        $this->assertEquals('pepe@example.com', $user->email);
        $this->assertNull($user->email_verified_at);
        $this->assertTrue(Hash::check('awesome-secret', $user->password));
        $this->assertEquals('2020-01-01 01:23:45', $user->password_changed_at);

        Event::assertDispatched(Registered::class, fn ($e) => $e->user->id === $user->id);
    }
}
