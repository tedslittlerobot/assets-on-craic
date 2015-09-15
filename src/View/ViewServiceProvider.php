<?php

namespace Tlr\Display\Components;

use Illuminate\Support\ServiceProvider;

class ComponentServiceProvider extends ServiceProvider
{

    /**
     * Boot the service
     *
     * @return void
     */
    public function boot()
    {
        $bladeCompiler = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        (new ViewBladeExtender)->register($bladeCompiler);
    }

    /**
     * Register the component library classes
     *
     * @return void
     */
    public function register()
    {
        //
    }

}
