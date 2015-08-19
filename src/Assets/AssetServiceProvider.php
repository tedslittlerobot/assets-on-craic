<?php

namespace Tlr\Assets\Assets;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider
{

    /**
     * The base uri
     *
     * @var string
     */
    protected $uri = 'assets';

    public function boot() {
        // @todo - register routes
    }

    /**
     * Register the component library classes
     *
     * @return void
     */
    public function register() {
        // @todo - register controller with uri
    }

}
