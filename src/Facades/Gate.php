<?php

namespace Bozboz\Permissions\Facades;

use Bozboz\Permissions\UserInterface;
use Illuminate\Support\Facades\Facade;

class Gate extends Facade
{
	protected static function getFacadeAccessor() { return 'permission.checker'; }

    static public function forUser(UserInterface $user)
    {
        return static::$app['permission.checker']->forUser($user);
    }
}
