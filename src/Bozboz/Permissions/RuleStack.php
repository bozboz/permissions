<?php

namespace Bozboz\Permissions;

use Bozboz\Permissions\Facades\Gate;

class RuleStack
{
	protected $rules = [];

	/**
	 * Add a rule to the stack with optional parameter
	 *
	 * @param  string  $rule
	 * @param  int  $param
	 * @return void
	 */
	public function add($rule, $param = null)
	{
		$this->rules[] = [$rule, $param];
	}

	/**
	 * Instantiate a new stack with a rule
	 *
	 * @param  string  $rule
	 * @param  int  $param
	 * @return self
	 */
	public static function with($rule, $param = null)
	{
		$stack = new static;
		$stack->add($rule, $param);

		return $stack;
	}

	/**
	 * Add a rule to the front of the rules queue
	 *
	 * @param  string  $rule
	 * @param  int  $param
	 * @return self
	 */
	public function then($rule, $param = null)
	{
		array_unshift($this->rules, [$rule, $param]);

		return $this;
	}

	/**
	 * Determine if rule stack contains a valid rule
	 *
	 * @return boolean
	 */
	public function isAllowed()
	{
		$allowed = false;

		while (count($this->rules) && $allowed === false) {
			list($rule, $param) = array_pop($this->rules);
			$allowed = Gate::allows($rule, $param);
		}

		return $allowed;
	}
}
