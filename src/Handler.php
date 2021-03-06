<?php

namespace Bozboz\Permissions;

class Handler
{
	protected $rules = [];

	/**
	 * Define a new rule, or set of rules, identified by a name and an
	 * associated Rule class
	 *
	 * @param string|array  $name
	 * @param string  $class
	 */
	public function define($name, $class = null)
	{
		$rules = is_array($name) ? $name : [$name => $class];

		foreach($rules as $name => $class) {
			$this->rules[$name] = $class;
		}
	}

	/**
	 * Check if a rule has been registered
	 *
	 * @param  string  $rule
	 * @return boolean
	 */
	public function has($rule)
	{
		return array_key_exists($rule, $this->rules);
	}

	/**
	 * Retrieve a rule, by its name and instantiate the class
	 *
	 * @param  string  $rule
	 * @return Bozboz\Permissions\Rules\Rule
	 */
	public function get($rule)
	{
		$instance = $this->rules[$rule];

		return new $instance($rule);
	}

	/**
	 * Dump current rules
	 *
	 * @return array
	 */
	public function dump()
	{
		return $this->rules;
	}
}
