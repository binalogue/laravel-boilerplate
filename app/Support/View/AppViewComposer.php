<?php

namespace Support\View;

use Illuminate\View\View;

class AppViewComposer
{
    public function compose(View $view): void
    {
        $view->with('data', $this->addGlobalData($view->getData()));
    }

    protected function addGlobalData(array $baseData): array
    {
        $settings = null;

        // @use-preset-nova-settings

        if (is_null($settings)) {
            $settings = config('binalogue');
        }

        return array_merge($baseData, [
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
