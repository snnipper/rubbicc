<?php

namespace Rubbicc;

use Illuminate\Support\Facades\Facade;

class RubbiccFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'rubbicc';
    }
}