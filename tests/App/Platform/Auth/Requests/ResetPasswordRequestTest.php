<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\ResetPasswordRequest;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Support\Testing\Concerns\ResetPasswordRoutes;
use Tests\RequestTestCase;

/** @see \App\Platform\Auth\Requests\ResetPasswordRequest */
class ResetPasswordRequestTest extends RequestTestCase
{
    use RefreshDatabase;
    use ResetPasswordRoutes;

    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = (new ResetPasswordRequest())->rules();
    }

    protected function getDefaults(): array
    {
        $user = User::factory()->create([
            'password' => Hash::make('old-password'),
        ]);

        return [
            'token' => $this->getValidToken($user),
            'email' => $user,
            'password' => 'new-awesome-password',
            'password_confirmation' => 'new-awesome-password',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Attribute: email
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function email_is_required()
    {
        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'email' => '',
            ]))
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Attribute: password
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function password_is_required()
    {
        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'password' => '',
                'password_confirmation' => '',
            ]))
        );
    }

    /** @test */
    public function password_confirmation_is_required()
    {
        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'password_confirmation' => '',
            ]))
        );
    }

    /** @test */
    public function password_must_have_a_matching_confirmation()
    {
        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'password' => 'new-awesome-password',
                'password_confirmation' => 'other-awesome-password',
            ]))
        );
    }
}
