<?php

namespace Tlr\Assets\Components;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tlr\Assets\Components\ComponentLibrary
 */
class ComponentFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'components';
    }
}
