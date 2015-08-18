<?php

namespace Tlr\Assets\Components;

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
    public function register() {
        $this->app->singleton(ComponentLibrary::class, function() {
            return new ComponentLibrary(
                $this->app->make(AssetManager::class),
                $this->app,
                $this->components,
            );
        });

        $this->app->alias(ComponentLibrary::class, 'components');
    }

}
