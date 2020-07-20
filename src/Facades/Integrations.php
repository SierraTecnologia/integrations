<?php

namespace Integrations\Facades;

use Illuminate\Support\Facades\Facade;

class Integrations extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'integrations';
    }
}
