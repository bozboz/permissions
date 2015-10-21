<?php

namespace Bozboz\Permissions;

interface UserInterface
{
	/**
	 * Return permissions matching the given $identifier, for the user
	 *
	 * @param  string  $identifier
	 * @param  int|null  $perform
	 * @return boolean
	 */
	public function canPerform($identifier, $param = null);
}
