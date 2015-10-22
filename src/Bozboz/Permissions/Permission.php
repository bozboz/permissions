<?php

namespace Bozboz\Permissions;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	const WILDCARD = '*';

	protected $fillable = [
		'action',
		'param',
		'user_id',
	];

	public function label()
	{
		$label = $this->action;

		if ($this->param) {
			$label .= ' [' . $this->param . ']';
		}

		return $label;
	}

	/**
	 * Determine if current rule matches requested action and parameter
	 *
	 * @param  string  $action
	 * @param  int  $param
	 * @return boolean
	 */
	public function isValid($action, $param)
	{
		return $this->isWildCard() || $action === $this->action && $param === $this->param;
	}

	/**
	 * Determine if current permission is a wildcard (can do everything)
	 *
	 * @return boolean
	 */
	protected function isWildCard()
	{
		return $this->action === static::WILDCARD;
	}
}
