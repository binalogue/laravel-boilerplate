<?php

namespace Support\View;

use Illuminate\Support\Collection;
use Illuminate\View\View;

class AppViewComposer
{
    public function compose(View $view): void
    {
        $view->with('data', $this->addGlobalData($view->data));
    }

    protected function addGlobalData($collection = null): Collection
    {
        if (is_null($collection)) {
            $collection = collect([]);
        }

        // @use-preset-nova-settings

        if (! isset($settings)) {
            $settings = config('binalogue');
        }

        return $collection->merge([
            // App.
            'env' => config('app.env'),
            'url' => config('app.url'),

            // Browser.
            'webp_support' => webp_support(),

            // Config
            'settings' => $settings,

            // Localization.
            'locale' => config('app.locale'),
            'fallback' => config('app.fallback_locale'),
            // 'messages' => ExportLocalizations::export()->toFlat(),
            'messages' => [],
        ]);
    }
}
