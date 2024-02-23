<?php

namespace Omaralalwi\LaravelTaxify;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Omaralalwi\LaravelTaxify\Skeleton\SkeletonClass
 */
class LaravelTaxifyFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-taxify';
    }
}
