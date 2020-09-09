<?php

namespace App\Nova\Users\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\HasMany;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Support\Nova\Resource;

/** @see \Tests\App\Nova\Users\Resources\RoleTest */
class Role extends Resource
{
    public static $model = \Domain\Users\Models\Role::class;

    public static $group = 'Admins';

    public static $title = 'name';

    public static $search = [
        'name',
    ];

    public static $globallySearchable = false;

    public static $defaultIndexOrder = 'id';

    public static $defaultIndexOrderDirection = 'asc';

    public function fields(Request $request): array
    {
        return [
            ID::make()
                ->sortable()
                ->canSee(fn ($request) => $request->user()->can('view-any-id', $this)),

            Text::make('Name')
                ->sortable()
                ->rules(['required', 'string', 'max:255'])
                ->creationRules('unique:roles')
                ->updateRules('unique:roles,name,{{resourceId}}'),

            HasMany::make('User', 'users'),
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
