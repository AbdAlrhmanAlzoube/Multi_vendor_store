<?php

namespace App\Facdes;

use App\Models\Role;
use Illuminate\Support\Facades\Facade;

class UpdateRole extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
         return 'update.role';;
    }
}