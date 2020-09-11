<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\ShowResetFormRequest;
use Tests\RequestTestCase;

/** @see \App\Platform\Auth\Requests\ShowResetFormRequest */
class ShowResetFormRequestTest extends RequestTestCase
{
    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = (new ShowResetFormRequest())->rules();
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
                ]),
            ],

            'email_must_be_valid' => [
                'passed' => false,
                'data' => $this->overwriteDefaults([
                    'email' => 'invalid-email',
                ]),
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
