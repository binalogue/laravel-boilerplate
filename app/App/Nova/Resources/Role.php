<?php

namespace App\Nova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;

class Role extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Domain\Users\Models\Role::class;

    /**
     * The logical group associated with the resource.
     *
     * @var string
     */
    public static $group = 'Users';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'name',
    ];

    /**
     * The default index order.
     *
     * @var string
     */
    public static $defaultIndexOrder = 'name';

    /**
     * The default index order direction.
     *
     * @var string
     */
    public static $defaultIndexOrderDirection = 'asc';

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
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

            Heading::make('Meta'),

            DateTime::make('Created At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),
            DateTime::make('Updated At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),

            BelongsToMany::make('User', 'users')
                ->searchable(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
