<?php

namespace Cybersource\Facades;

use Illuminate\Support\Facades\Facade;

class Cybersource extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        self::clearResolvedInstance('cybersource');
        return 'cybersource';
    }
}