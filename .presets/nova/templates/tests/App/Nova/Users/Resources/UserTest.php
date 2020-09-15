<?php

namespace Tests\App\Nova\Users\Resources;

use App\Nova\Users\Resources\User as UserResource;
use Database\Factories\UserFactory;
use Domain\Users\Models\Role;
use Tests\NovaTestCase;

/** @see \App\Nova\Users\Resources\User */
class UserTest extends NovaTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->user->assignRole(Role::SUPERADMIN);
    }

    /*
    |--------------------------------------------------------------------------
    | Config
    |--------------------------------------------------------------------------
    */

    /** @test **/
    public function it_displays_in_navigation()
    {
        $this->assertTrue(UserResource::$displayInNavigation);
    }

    /** @test **/
    public function it_is_globally_searchable()
    {
        $this->assertTrue(UserResource::$globallySearchable);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: Index
    |--------------------------------------------------------------------------
    */

    /** @test **/
    public function users_can_be_retrieved_ordered_by_id_desc()
    {
        $user2 = UserFactory::new()->create();

        $this
            ->get('nova-api/users')
            ->assertJson([
                'label' => 'Users',
                'resources' => [
                    [
                        'id' => [
                            'value' => $user2->id,
                        ],
                    ],
                    [
                        'id' => [
                            'value' => $this->user->id,
                        ],
                    ],
                ],
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: Store
    |--------------------------------------------------------------------------
    */

    /** @test **/
    public function first_name_is_required_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'first_name' => '',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('first_name');
    }

    /** @test **/
    public function first_name_must_be_under_255_chars_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'first_name' => str_repeat('J', 256),
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('first_name');
    }

    /** @test **/
    public function last_name_is_required_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'last_name' => '',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('last_name');
    }

    /** @test **/
    public function last_name_must_be_under_255_chars_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'last_name' => str_repeat('J', 256),
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('last_name');
    }

    /** @test **/
    public function email_is_required_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'email' => '',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function email_must_be_valid_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'email' => 'invalid-email',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function email_must_be_under_254_chars_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'email' => str_repeat('J', 255),
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function email_must_be_unique_on_create()
    {
        UserFactory::new()->create([
            'email' => 'pepe@grillo.com',
        ]);

        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'email' => 'pepe@grillo.com',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function password_is_required_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'password' => '',
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('password');
    }

    /** @test **/
    public function password_must_be_string_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'password' => 12345678,
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('password');
    }

    /** @test **/
    public function password_must_be_8_chars_on_create()
    {
        $this
            ->from('nova/resources/users/new')
            ->post('nova-api/users', [
                'password' => 1234567,
            ])
            ->assertRedirect('nova/resources/users/new')
            ->assertSessionHasErrors('password');
    }

    /** @test **/
    public function user_has_correct_validation_on_create()
    {
        $attributes = [
            'first_name' => 'Pepe',
            'last_name' => 'Grillo',
            'email' => 'pepe@grillo.com',
            'password' => 'awesome-password',
        ];

        $this
            ->post('nova-api/users/', $attributes)
            ->assertSuccessful();
    }

    /*
    |--------------------------------------------------------------------------
    | Action: Show
    |--------------------------------------------------------------------------
    */

    /** @test **/
    public function user_can_be_retrieved_with_correct_resource_elements()
    {
        $this
            ->get("nova-api/users/{$this->user->id}")
            ->assertJson([
                'resource' => [
                    'id' => [
                        'value' => $this->user->id,
                    ],
                    'fields' => [
                        [
                            'attribute' => 'id',
                            'component' => 'id-field',
                            'name' => 'ID',
                            'sortable' => true,
                            'value' => $this->user->id,
                        ],
                        [
                            'attribute' => 'email',
                            'component' => 'file-field',
                            'name' => 'Avatar',
                            'value' => null,
                            'thumbnailUrl' => 'https://www.gravatar.com/avatar/' . md5($this->user->email) . '?s=300',
                        ],
                        [
                            'attribute' => 'first_name',
                            'component' => 'text-field',
                            'name' => 'First Name',
                            'sortable' => true,
                            'value' => $this->user->first_name,
                        ],
                        [
                            'attribute' => 'last_name',
                            'component' => 'text-field',
                            'name' => 'Last Name',
                            'sortable' => true,
                            'value' => $this->user->last_name,
                        ],
                        [
                            'attribute' => 'email',
                            'component' => 'text-field',
                            'name' => 'Email',
                            'sortable' => true,
                            'value' => $this->user->email,
                        ],
                        [
                            'attribute' => 'has_notifications_enabled',
                            'component' => 'boolean-field',
                            'name' => 'Has Notifications Enabled',
                            'value' => $this->user->has_notifications_enabled,
                        ],
                        [
                            'attribute' => 'role',
                            'component' => 'belongs-to-field',
                            'name' => 'Role',
                            'value' => $this->user->role->name,
                        ],
                        [
                            'attribute' => 'extra_attributes',
                            'component' => 'key-value-field',
                            'name' => 'Extra Attributes',
                            'value' => [],
                        ],
                        [
                            'component' => 'heading-field',
                            'value' => 'Meta',
                        ],
                        [
                            'attribute' => 'created_at',
                            'component' => 'date-time',
                            'name' => 'Created At',
                            'value' => $this->user->created_at,
                        ],
                        [
                            'attribute' => 'updated_at',
                            'component' => 'date-time',
                            'name' => 'Updated At',
                            'value' => $this->user->updated_at,
                        ],
                    ],
                ],
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Action: Update
    |--------------------------------------------------------------------------
    */

    /** @test **/
    public function email_must_be_unique_on_update()
    {
        UserFactory::new()->create([
            'email' => 'pepe@grillo.com',
        ]);

        $this
            ->from("nova/resources/users/{$this->user->id}/edit")
            ->put(
                "nova-api/users/{$this->user->id}",
                [
                    'email' => 'pepe@grillo.com',
                ]
            )
            ->assertRedirect("nova/resources/users/{$this->user->id}/edit")
            ->assertSessionHasErrors('email');
    }

    /** @test **/
    public function email_must_be_unique_except_for_self_on_update()
    {
        $this
            ->put(
                "nova-api/users/{$this->user->id}",
                UserFactory::new()->make([
                    'email' => $this->user->email,
                ])->toArray()
            )
            ->assertSuccessful();
    }

    /** @test **/
    public function password_can_be_nullable_on_update()
    {
        $this
            ->put(
                "nova-api/users/{$this->user->id}",
                UserFactory::new()->make([
                    'password' => null,
                ])->toArray()
            )
            ->assertSuccessful();
    }

    /** @test **/
    public function password_must_be_string_on_update()
    {
        $this
            ->from("nova/resources/users/{$this->user->id}/edit")
            ->put(
                "nova-api/users/{$this->user->id}",
                [
                    'password' => 12345678,
                ]
            )
            ->assertRedirect("nova/resources/users/{$this->user->id}/edit")
            ->assertSessionHasErrors('password');
    }

    /** @test **/
    public function password_must_be_8_chars_on_update()
    {
        $this
            ->from("nova/resources/users/{$this->user->id}/edit")
            ->put(
                "nova-api/users/{$this->user->id}",
                [
                    'password' => 1234567,
                ]
            )
            ->assertRedirect("nova/resources/users/{$this->user->id}/edit")
            ->assertSessionHasErrors('password');
    }
}
