<?php

namespace App\Http\View\Composers;

use App\Services\AppService;
use Illuminate\View\View;

class AppComposer
{
    /**
     * The app service.
     */
    protected $app;

    /**
     * Create a new app composer.
     *
     * @param  \App\Services\AppService  $app
     */
    public function __construct(AppService $app)
    {
        $this->app = $app;
    }

    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('data', $this->app->addGlobalData($view->data));
    }
}
