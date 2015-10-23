<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Exceptions\InvalidParameterException;
use Bozboz\Permissions\UserInterface;

class GlobalRule extends Rule
{
	/**
	 * @inheritdoc
	 */
	public function validFor(UserInterface $user, $param)
	{
		$this->validate($param);

		return parent::validFor($user, $param);
	}

	/**
	 * Determine if the rule can accept a parameter
	 *
	 * @param  int  $param
	 * @throws Bozboz\Permissions\Exceptions\InvalidParameterException
	 * @return void
	 */
	protected function validate($param)
	{
		if ( ! empty($param)) throw new InvalidParameterException(
			"'{$this->alias}' permission does not accept a parameter"
		);
	}
}
