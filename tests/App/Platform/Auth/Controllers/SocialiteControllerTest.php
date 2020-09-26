<?php

namespace Tests\App\Platform\Auth\Controllers;

use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\AbstractUser as SocialiteUser;
use Laravel\Socialite\Contracts\Factory as Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Support\Providers\RouteServiceProvider;
use Support\Testing\Concerns\SocialiteRoutes;
use Tests\TestCase;

/** @see \App\Platform\Auth\Controllers\SocialiteController */
class SocialiteControllerTest extends TestCase
{
    use RefreshDatabase;
    use SocialiteRoutes;

    protected function mockSocialiteFacade(
        string $email = 'pepe@grillo.com',
        string $token = 'foo',
        string $id = '1'
    ): void {
        $socialiteUser = $this->createMock(SocialiteUser::class);

        $socialiteUser->token = $token;
        $socialiteUser->id = $id;
        $socialiteUser->email = $email;
        $socialiteUser->name = 'Pepe Grillo';
        $socialiteUser->avatar = 'pepegrillo.jpg';

        $socialiteUser->method('getId')->willReturn($socialiteUser->id);
        $socialiteUser->method('getEmail')->willReturn($socialiteUser->email);
        $socialiteUser->method('getName')->willReturn($socialiteUser->name);
        $socialiteUser->method('getAvatar')->willReturn($socialiteUser->avatar);

        $provider = $this->createMock(GoogleProvider::class);

        $provider
            ->expects($this->any())
            ->method('user')
            ->willReturn($socialiteUser);

        $stub = $this->createMock(Socialite::class);
        $stub
            ->expects($this->any())
            ->method('driver')
            ->willReturn($provider);

        $this->app->instance(Socialite::class, $stub);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: redirectToProvider
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_redirects_to_google()
    {
        $response = $this->get($this->socialiteRedirectRoute('google'));

        $this->assertStringContainsString('https://accounts.google.com/o/oauth2/auth', $response->getTargetUrl());
    }

    /*
    |--------------------------------------------------------------------------
    | Action: handleProviderCallback
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function it_redirects_to_the_successful_route_when_existing_user()
    {
        $user = User::factory()->create([
            'email' => 'pepe@grillo.com',
        ]);

        $this->mockSocialiteFacade($user->email);

        $this
            ->get($this->socialiteCallbackRoute('google'))
            ->assertRedirect(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->google_id);
    }

    /** @test */
    public function it_restores_the_user_when_trashed()
    {
        $user = User::factory()->trashed()->create([
            'email' => 'pepe@grillo.com',
        ]);

        $this->mockSocialiteFacade($user->email);

        $this
            ->get($this->socialiteCallbackRoute('google'))
            ->assertRedirect(RouteServiceProvider::SUCCESSFUL_LOGIN_ROUTE);

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->google_id);
        $this->assertNull($user->fresh()->deleted_at);
    }

    /** @test */
    public function it_returns_a_new_user_when_doesnt_exist()
    {
        $this->mockSocialiteFacade('pepe@grillo.com');

        $this
            ->get($this->socialiteCallbackRoute('google'))
            ->assertSuccessful()
            ->assertPropValue('newUser', function ($newUser) {
                $this->assertNotNull('first_name');
                $this->assertNotNull('last_name');
                $this->assertEquals('pepe@grillo.com', $newUser['email']);
                $this->assertNotNull('google_id');
                $this->assertNotNull('avatar');
            });
    }
}
