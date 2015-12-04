<?php

namespace Bozboz\Permissions\Rules;

use Illuminate\Database\Eloquent\Model;

class ModelRule extends Rule
{
	/**
	 * Get key from passed $instance, if it exists
	 *
	 * @param  Illuminate\Database\Eloquent\Model  $instance
	 * @return int
	 */
	public function getParamForPermission($instance)
	{
		return $instance ? $instance->getKey() : null;
	}
}
