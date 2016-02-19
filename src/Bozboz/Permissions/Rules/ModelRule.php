<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Permission;
use Illuminate\Database\Eloquent\Model;

class ModelRule extends Rule
{
	/**
	 * Determine if a given permission is valid for the rule, using the key of
	 * the given instance parameter
	 *
	 * @param  Bozboz\Permissions\Permission  $permission
	 * @param  Illuminate\Database\Eloquent\Model  $instance
	 * @return boolean
	 */
	protected function isPermissionValid(Permission $permission, $instance)
	{
		$param = $instance ? $instance->getKey() : null;

		return parent::isPermissionValid($permission, $param);
	}
}
