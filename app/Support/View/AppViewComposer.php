<?php

namespace Support\View;

use Illuminate\View\View;
use KgBot\LaravelLocalization\Facades\ExportLocalizations;

class AppViewComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('data', $this->addGlobalData($view->data));
    }

    /**
     * Add application global data to collection.
     */
    private function addGlobalData($collection = null)
    {
        if (is_null($collection)) {
            $collection = collect([]);
        }

        return $collection->merge([
            // App.
            'env' => config('app.env'),
            'url' => config('app.url'),

            // Browser.
            'webp_support' => webp_support(),

            // Localization.
            'locale' => config('app.locale'),
            'fallback' => config('app.fallback_locale'),
            'messages' => ExportLocalizations::export()->toFlat(),
        ]);
    }
}
