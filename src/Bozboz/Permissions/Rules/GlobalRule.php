<?php

namespace Bozboz\Permissions\Rules;

use Bozboz\Permissions\Exceptions\InvalidParameterException;

class GlobalRule extends Rule
{
	protected function getParamForPermission($param)
	{
		if ( ! empty($param)) throw new InvalidParameterException(
			"'{$this->alias}' permission does not accept a parameter"
		);
	}
}
