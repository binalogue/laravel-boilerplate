<?php

namespace App\Nova\Users\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;
use Support\Nova\Resource;

/** @see \Tests\App\Nova\Users\Resources\UserTest */
class User extends Resource
{
    public static $model = \Domain\Users\Models\User::class;

    public static $group = 'Users';

    public static $title = 'full_name';

    public static $with = [
        'role',
    ];

    public static $search = [
        'id',
        'first_name',
        'last_name',
        'email',
    ];

    public static $defaultIndexOrder = 'id';

    public static $defaultIndexOrderDirection = 'desc';

    public static $priority = 1;

    public function fields(Request $request): array
    {
        return [
            ID::make()
                ->sortable()
                ->canSeeWhen('viewAnyId', $this),

            Gravatar::make(),

            Text::make('First Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Last Name')
                ->sortable()
                ->rules(['required', 'max:255']),

            Text::make('Email')
                ->sortable()
                ->rules(['required', 'email', 'max:254'])
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}')
                ->hideWhenUpdating(function ($request) {
                    return ! $request->user()->can('updateEmailAttribute', $this->model());
                }),

            Password::make('Password')
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->onlyOnForms()
                ->hideWhenUpdating(function ($request) {
                    return ! $request->user()->can('updatePasswordAttribute', $this->model());
                }),

            Boolean::make('Has Notifications Enabled')
                ->canSee(function ($request) {
                    return $request->user()->can('updateHasNotificationsEnabledAttribute', $this->model());
                }),

            BelongsTo::make('Role', 'role', \App\Nova\Users\Resources\Role::class)
                ->hideWhenUpdating(function ($request) {
                    return ! $request->user()->can('updateRoleAttribute', $this->model());
                })
                ->nullable(),

            KeyValue::make('Extra Attributes', 'extra_attributes')
                ->resolveUsing(function ($value) {
                    return collect($value)->sortKeys()->toArray();
                })
                ->rules('json'),

            // Meta
            Heading::make('Meta')
                ->onlyOnDetail(),

            DateTime::make('Created At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),

            DateTime::make('Updated At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),
            // End Meta
        ];
    }

    public function cards(Request $request): array
    {
        return [];
    }

    public function filters(Request $request): array
    {
        return [];
    }

    public function lenses(Request $request): array
    {
        return [];
    }

    public function actions(Request $request): array
    {
        return [];
    }
}
