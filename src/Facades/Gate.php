<?php

namespace Bozboz\Permissions\Facades;

use Illuminate\Support\Facades\Facade;

class Gate extends Facade
{
	protected static function getFacadeAccessor() { return 'permission.checker'; }
}
