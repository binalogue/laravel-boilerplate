<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\RegisterRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\RequestTestCase;

/** @see \App\Platform\Auth\Requests\RegisterRequest */
class RegisterRequestTest extends RequestTestCase
{
    use RefreshDatabase;

    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = (new RegisterRequest())->rules();
    }

    protected function getDefaults(): array
    {
        return [
            'first_name' => 'Pepe',
            'last_name' => 'Grillo',
            'email' => 'pepe@grillo.com',
            'password' => 'awesome-password',
            'password_confirmation' => 'awesome-password',
        ];
    }

    public function validationProvider(): array
    {
        return [
            'first_name_is_required' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'first_name' => '',
                ])
            ],

            'last_name_is_required' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'last_name' => '',
                ])
            ],

            'email_is_required' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'email' => '',
                ])
            ],

            'email_must_be_valid' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'email' => 'invalid-email',
                ])
            ],

            'password_is_required' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'password' => '',
                    'password_confirmation' => '',
                ])
            ],

            'password_confirmation_is_required' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'password_confirmation' => '',
                ])
            ],

            'password_must_have_a_matching_confirmation' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'password' => 'awesome-password',
                    'password_confirmation' => 'other-awesome-password',
                ])
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validationProvider
     */
    public function request_validation(bool $shouldPass, array $attributes)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($attributes)
        );
    }
}
