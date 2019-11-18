<?php

namespace App\Services;

use Illuminate\Http\Request;
use KgBot\LaravelLocalization\Facades\ExportLocalizations;

class AppService
{
    /**
     * The HTTP request.
     */
    protected $request;

    /**
     * Create a new service instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Generate meta collection.
     */
    private function generateMeta(
        $title,
        $description,
        $image,
        $image_width,
        $image_height
    ) {
        return collect([
            'title' => $title,
            'description' => $description,
            'image' => $image,
            'image_width' => $image_width,
            'image_height' => $image_height,
        ]);
    }

    /**
     * Get meta properties for each page.
     */
    private function getMeta()
    {
        $title = config('app.name');
        $description = config('app.description');
        $image = asset('/images/binalogue-og.jpg');
        $image_width = '1200';
        $image_height = '630';

        return collect([
            'home' => $this->generateMeta(
                $title,
                $description,
                $image,
                $image_width,
                $image_height
            ),
        ]);
    }

    /**
     * Add application global data to collection.
     */
    public function addGlobalData($collection = null)
    {
        if (is_null($collection)) {
            $collection = collect([]);
        }

        return $collection->merge([
            // App.
            'env' => config('app.env'),
            'url' => config('app.url'),
            'path' => $this->request->getPathInfo(),
            'meta' => $this->getMeta(),

            // Browser.
            'webp_support' => webp_support(),

            // Localization.
            'locale' => config('app.locale'),
            'fallback' => config('app.fallback_locale'),
            'messages' => ExportLocalizations::export()->toFlat(),

            // Services.
            'google_analytics_id' => config('services.googleanalytics.id'),
        ]);
    }
}
