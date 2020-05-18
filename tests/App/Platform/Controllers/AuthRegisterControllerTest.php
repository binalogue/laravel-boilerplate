<?php

namespace Tests\App\Platform\Controllers;

use Domain\Users\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AuthRegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();
        Carbon::setTestNow(
            Carbon::createFromFormat('Y-m-d H:i:s', '2020-01-01 01:23:45')
        );
    }

    /** @test */
    public function user_can_view_pre_register_page()
    {
        $response = $this->get(route('register'));

        $response->assertSuccessful();
    }

    /** @test */
    public function user_can_view_register_page()
    {
        $response = $this->call('GET', route('register.email'), [
            'email' => 'pepito@grillo.com',
        ]);

        $response->assertSuccessful();
    }

    /** @test */
    public function user_can_register()
    {
        $response = $this
            ->from(route('register.email'))
            ->post(route('register.post'), [
                'name' => 'Pepito',
                'first_surname' => 'Grillo',
                'email' => 'pepito@grillo.com',
                'password' => 'strong-secret',
                'password_confirmation' => 'strong-secret',
            ]);

        $this->assertNotNull(
            $user = User::where('email', 'pepito@grillo.com')->firstOrFail()
        );

        $this->assertEquals('Pepito', $user->name);
        $this->assertEquals('Grillo', $user->first_surname);
        $this->assertNotNull($user->password);
        $this->assertEquals('2020-01-01 01:23:45', $user->password_changed_at);

        Event::assertDispatched(Registered::class);

        $this->assertAuthenticatedAs($user);

        $response->assertRedirect(route('profile.show'));
    }
}
