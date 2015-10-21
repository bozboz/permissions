<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Exceptions\InvalidParameterException;
use Bozboz\Permissions\UserInterface;

class Rule
{
	protected $alias;
	protected $noParam = false;

	public function __construct($alias)
	{
		$this->alias = $alias;
	}

	/**
	 * Determine if user is authorized for current rule
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @param  int  $param
	 * @return boolean
	 */
	public function validFor(UserInterface $user, $param)
	{
		$this->validate($param);

		return $user->canPerform($this->alias, $param);
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
		if ( ! empty($param) && $this->noParam) throw new InvalidParameterException(
			"'{$this->alias}' permission does not accept a parameter"
		);
	}
}
