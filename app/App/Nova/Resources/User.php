<?php

namespace App\Nova\Resources;

use Illuminate\Http\Request;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\Heading;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Text;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \Domain\Users\Models\User::class;

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
        'id',
        'name',
        'email',
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
                ->canSeeWhen('view-any-id', $this),

            Gravatar::make(),

            Text::make('Name')
                ->sortable()
                ->rules('required', 'max:255'),
            Text::make('First Surname')
                ->sortable()
                ->rules('max:255'),
            Text::make('Second Surname')
                ->sortable()
                ->rules('max:255')
                ->hideFromIndex(),

            Text::make('Email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:users,email')
                ->updateRules('unique:users,email,{{resourceId}}')
                ->hideWhenUpdating(function ($request) {
                    return !$request->user()->can('update-email', $this->model());
                }),

            Password::make('Password')
                ->creationRules('required', 'string', 'min:8')
                ->updateRules('nullable', 'string', 'min:8')
                ->onlyOnForms()
                ->hideWhenUpdating(function ($request) {
                    return !$request->user()->can('update-password', $this->model());
                }),

            KeyValue::make('Extra Attributes', 'extra_attributes')
                ->resolveUsing(function ($value) {
                    return collect($value)->sortKeys()->toArray();
                })
                ->rules('json'),

            Heading::make('Meta'),

            DateTime::make('Created At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),
            DateTime::make('Updated At')
                ->format('MMM DD, YYYY, HH:mm:ss')
                ->onlyOnDetail(),
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
