<?php

namespace Tests\App\Platform\Auth\Requests;

use App\Platform\Auth\Requests\AuthRegisterRequest;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\Factory as Validator;
use Tests\TestCase;

class AuthRegisterRequestTest extends TestCase
{
    use RefreshDatabase;

    private Validator $validator;
    private array $rules;

    public function setUp(): void
    {
        parent::setUp();

        $this->validator = App::get('validator');
        $this->rules = (new AuthRegisterRequest())->rules();
    }

    protected function validate($mockedRequestData)
    {
        return $this->validator
            ->make($mockedRequestData, $this->rules)
            ->passes();
    }

    /* WithFaker trait doesn't work in the dataProvider */
    public function validationProvider()
    {
        $faker = Factory::create();

        $password = $faker->password(8);

        return [
            'request_should_fail_when_no_name_is_provided' => [
                'passed' => false,
                'data' => [
                    'first_surname' => $faker->lastName,
                    'email' => $faker->email,
                ],
            ],

            'request_should_fail_when_no_first_surname_is_provided' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->firstName,
                    'email' => $faker->email,
                ],
            ],

            'request_should_fail_when_no_email_is_provided' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->firstName,
                    'first_surname' => $faker->lastName,
                ],
            ],

            'request_should_fail_when_email_is_invalid' => [
                'passed' => false,
                'data' => [
                    'email' => 'invalid-email',
                ],
            ],

            'request_should_fail_when_password_is_not_confirmed' => [
                'passed' => false,
                'data' => [
                    'name' => $faker->firstName,
                    'first_surname' => $faker->lastName,
                    'email' => $faker->email,
                    'password' => $password,
                ],
            ],

            'request_should_pass_when_data_is_provided' => [
                'passed' => true,
                'data' => [
                    'name' => $faker->firstName,
                    'first_surname' => $faker->lastName,
                    'email' => $faker->email,
                    'password' => $password,
                    'password_confirmation' => $password,
                ],
            ],
        ];
    }

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function user_can_register_with_email($shouldPass, $mockedRequestData)
    {
        $this->assertEquals(
            $shouldPass,
            $this->validate($mockedRequestData)
        );
    }
}
