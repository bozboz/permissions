<?php

namespace Bozboz\Permissions\Rules;

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
			return $permission->isMatchingAction($this->alias) && ! is_null($permission->param);
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
		$param = $this->getParamForPermission($param);

		return $user->getPermissions()->filter(function($permission) use ($param) {
			return $permission->isValid($this->alias, $param);
		})->count() > 0;
	}

	/**
	 * Amend the passed rule parameter to pass to the permission check
	 *
	 * @param  mixed  $param
	 * @return mixed
	 */
	protected function getParamForPermission($param)
	{
		return $param;
	}
}
