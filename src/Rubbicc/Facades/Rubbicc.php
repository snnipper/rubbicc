<?php

namespace Rubbicc\Facades;

use Illuminate\Support\Facades\Facade;

class Rubbicc extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rubbicc';
    }
}