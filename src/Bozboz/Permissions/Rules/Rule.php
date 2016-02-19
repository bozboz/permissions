<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Permission;
use Bozboz\Permissions\UserInterface;

class Rule
{
	protected $alias;

	public function __construct($alias)
	{
		$this->alias = $alias;
	}

	/**
	 * Determine if rule is valid for current user
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @param  mixed  $param
	 * @return boolean
	 */
	public function validFor(UserInterface $user, $param)
	{
		return $this->checkUserPermissions($user, $param);
	}

	/**
	 * Get an array of authorised parameters for the $user for rule
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @return array
	 */
	public function getParams(UserInterface $user)
	{
		return $user->getPermissions()->filter(function($permission) {
			return $permission->matchesAction($this->alias) && ! is_null($permission->param);
		})->lists('param');
	}

	/**
	 * Check user permissions
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @param  mixed  $param
	 * @return boolean
	 */
	protected function checkUserPermissions(UserInterface $user, $param)
	{
		return $user->getPermissions()->filter(function($permission) use ($param) {
			return $this->isPermissionValid($permission, $param);
		})->count() > 0;
	}

	/**
	 * Determine if a given permission is valid for the rule
	 *
	 * @param  Bozboz\Permissions\Permission  $permission
	 * @param  mixed  $param
	 * @return boolean
	 */
	protected function isPermissionValid(Permission $permission, $param)
	{
		return $permission->matches($this->alias, $param);
	}
}
