<?php

namespace Tcp\Support\Components;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Tcp\Support\Components\ComponentLibrary
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
