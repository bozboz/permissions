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

	/**
	 * Determine if current rule matches requested action and parameter
	 *
	 * @param  string  $action
	 * @param  int  $param
	 * @return boolean
	 */
	public function isValid($action, $param)
	{
		return $this->isWildCard() || ($this->isMatchingAction($action) && $this->isValidParam($param));
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

	/**
	 * Determine if passed action matches permission
	 *
	 * @param  string  $action
	 * @return boolean
	 */
	protected function isMatchingAction($action)
	{
		return $this->action === $action;
	}

	/**
	 * Determine if parameter is valid for permission
	 *
	 * @param  mixed  $param
	 * @return boolean
	 */
	protected function isValidParam($param)
	{
		return is_null($this->param) || $param === $this->param;
	}
}
