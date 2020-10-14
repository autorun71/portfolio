<?php

namespace Webkul\Ecom\Traits;

trait ErrorTrait
{
    protected function notType()
    {
        throw new \Exception('Not exist type of exchange! Use static method import() or export()');
    }

    protected function notDataType($type)
    {
        throw new \Exception('Not exist ' . $type . ' datatype! ');
    }
}