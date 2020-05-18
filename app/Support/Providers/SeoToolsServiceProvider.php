<?php

namespace Support\Providers;

use Support\SeoTools\Contracts;
use Support\SeoTools\FacebookSharing;
use Support\SeoTools\MetaTags;
use Support\SeoTools\OpenGraph;
use Support\SeoTools\TwitterCards;
use Illuminate\Config\Repository as Config;
use Illuminate\Support\ServiceProvider;

class SeoToolsServiceProvider extends ServiceProvider
{
    /**
     * Register SeoTools services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('seotools.metatags', function ($app) {
            return new MetaTags(new Config($app['config']->get('seotools.meta', [])));
        });

        $this->app->singleton('seotools.opengraph', function ($app) {
            return new OpenGraph($app['config']->get('seotools.opengraph', []));
        });

        $this->app->singleton('seotools.twitter', function ($app) {
            return new TwitterCards($app['config']->get('seotools.twitter.defaults', []));
        });

        $this->app->singleton('seotools.facebook', function ($app) {
            return new FacebookSharing($app['config']->get('seotools.facebook', []));
        });

        $this->app->bind(Contracts\MetaTags::class, 'seotools.metatags');
        $this->app->bind(Contracts\OpenGraph::class, 'seotools.opengraph');
        $this->app->bind(Contracts\TwitterCards::class, 'seotools.twitter');
        $this->app->bind(Contracts\FacebookSharing::class, 'seotools.facebook');
    }

    /**
     * Bootstrap SeoTools services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
