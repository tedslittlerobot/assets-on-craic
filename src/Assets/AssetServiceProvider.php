<?php

namespace Tlr\Assets\Assets;

use Illuminate\Support\ServiceProvider;
use Tlr\Assets\Assets\ActiveAssetCollection;
use Tlr\Assets\Assets\AssetCollection;

class AssetServiceProvider extends ServiceProvider
{

    /**
     * The base uri
     *
     * @var string
     */
    protected $uri = 'assets';

    /**
     * Boot the service
     *
     * @return void
     */
    public function boot()
    {
        $this->routes();
    }

    /**
     * Register the asset routes
     *
     * @return void
     */
    protected function routes()
    {
        $this->app['router']->get($this->uri('scripts.js'), [
            'as' => 'assets.js',
            'uses' => AssetRenderController::class . '@scripts'
        ]);

        $this->app['router']->get($this->uri('styles.css'), [
            'as' => 'assets.css',
            'uses' => AssetRenderController::class . '@styles'
        ]);
    }

    /**
     * Generate a route url with the given suffix
     *
     * @param  string $suffix
     * @return string
     */
    protected function uri($suffix)
    {
        return sprintf('%s/%s', $this->uri, $suffix);
    }

    /**
     * Register the component library classes
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ActiveAssetCollection::class, function() {
            return $this->app->make(ActiveAssetCollection::class);
        });

        $this->app->singleton(AssetCollection::class, function() {
            return $this->app->make(AssetCollection::class);
        });
    }

}
