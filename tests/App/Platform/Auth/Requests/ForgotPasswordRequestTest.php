<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\ForgotPasswordRequest;
use Tests\RequestTestCase;

/** @see \App\Platform\Auth\Requests\ForgotPasswordRequest */
class ForgotPasswordRequestTest extends RequestTestCase
{
    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = (new ForgotPasswordRequest())->rules();
    }

    protected function getDefaults(): array
    {
        return [
            'email' => 'pepe@grillo.com',
        ];
    }

    public function validationProvider(): array
    {
        return [
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
