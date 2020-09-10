<?php

namespace Support\View;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use KgBot\LaravelLocalization\Facades\ExportLocalizations;

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

        $novaSettings = collect(nova_get_settings())
            ->mapWithKeys(function ($value, $key) {
                if ($key === 'logo' && $value) {
                    $value = asset("storage/{$value}");
                }

                return [$key => $value];
            })
            ->toArray();

        if (!Arr::get($novaSettings, 'logo')) {
            Arr::set($novaSettings, 'logo', asset('images/logo.png'));
        }

        return $collection->merge([
            // App.
            'env' => config('app.env'),
            'url' => config('app.url'),

            // Browser.
            'webp_support' => webp_support(),

            // Config
            'nova_settings' => $novaSettings,

            // Localization.
            'locale' => config('app.locale'),
            'fallback' => config('app.fallback_locale'),
            'messages' => ExportLocalizations::export()->toFlat(),
        ]);
    }
}
