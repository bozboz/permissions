<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Permission;
use Bozboz\Permissions\Exceptions\InvalidParameterException;

class GlobalRule extends Rule
{
	/**
	 * Determine if a given permission is valid for the rule, and ensure no
	 * param is passed when checking.
	 *
	 * @param  Bozboz\Permissions\Permission  $permission
	 * @param  mixed  $param
	 * @throws Bozboz\Permissions\Exceptions\InvalidParameterException
	 * @return boolean
	 */
	protected function isPermissionValid(Permission $permission, $param)
	{
		if ( ! empty($param)) throw new InvalidParameterException(
			"'{$this->alias}' permission does not accept a parameter"
		);

		return $permission->matchesAction($this->alias);
	}
}
