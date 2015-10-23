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
	 * @param  int  $param
	 * @return boolean
	 */
	public function validFor(UserInterface $user, $param)
	{
		return $this->checkUserPermissions($user, $param);
	}

	/**
	 * Check user permissions
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @param  int  $param
	 * @return boolean
	 */
	protected function checkUserPermissions(UserInterface $user, $param)
	{
		return $user->getPermissions()->filter(function($item) use ($param) {
			return $item->isValid($this->alias, $param);
		})->count() > 0;
	}
}
