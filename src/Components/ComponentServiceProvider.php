<?php

namespace Tlr\Display\Components;

use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{

    /**
     * A map of components
     *
     * @var array
     */
    protected $components = [];

    /**
     * Register the component library classes
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(ComponentLibrary::class, function()
    {
            $assets = $this->app->make(AssetManager::class);

            return new ComponentLibrary(
                $assets,
                $this->app,
                $this->components
            );
        });

        $this->app->alias(ComponentLibrary::class, 'components');
    }

}
