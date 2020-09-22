<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\PreRegisterRequest;
use Domain\Users\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\RequestTestCase;

/** @see \App\Platform\Auth\Requests\PreRegisterRequest */
class PreRegisterRequestTest extends RequestTestCase
{
    use RefreshDatabase;

    protected array $rules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rules = (new PreRegisterRequest())->rules();
    }

    protected function getDefaults(): array
    {
        return [
            'email' => 'pepe@grillo.com',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Attribute: email
    |--------------------------------------------------------------------------
    */

    /** @test */
    public function email_must_be_vaid()
    {
        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'email' => 'invalid-email',
            ]))
        );
    }

    /** @test */
    public function email_must_be_unique()
    {
        User::factory()->create([
            'email' => 'pepe@pepe.es',
        ]);

        $this->assertEquals(
            false,
            $this->validate($this->overwriteDefaults([
                'email' => 'pepe@pepe.es',
            ]))
        );
    }
}
