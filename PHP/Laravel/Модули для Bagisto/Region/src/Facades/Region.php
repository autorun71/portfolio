<?php

namespace Webkul\Region\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * Class Region
 * @package Webkul\Region\Facades
 * @method setUrl(string $url) static
 * @method getRegion() static
 * @method getProps() static
 * @method hasRegion(string $code) static
 * @method instance() static

 */
class Region extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'region';
    }
}
