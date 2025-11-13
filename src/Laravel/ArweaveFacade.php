<?php

namespace Arweave\Cli\Laravel;

use Illuminate\Support\Facades\Facade;

class ArweaveFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'arweave-cli';
    }
}
