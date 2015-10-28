<?php

namespace Bozboz\Permissions;

use Illuminate\Auth\Guard;

class Checker
{
	protected $handler;
	protected $auth;
	protected $forUser;

	public function __construct(Handler $handler, Guard $auth)
	{
		$this->handler = $handler;
		$this->auth = $auth;
	}

	/**
	 * Check permissions of a specific user
	 *
	 * @param  Bozboz\Permissions\UserInterface  $user
	 * @return $this
	 */
	public function forUser(UserInterface $user)
	{
		$this->forUser = $user;

		return $this;
	}

	/**
	 * Determine if current registered user is allowed to perform the specified
	 * action (in optional context)
	 *
	 * @param  string  $action
	 * @param  mixed  $context
	 * @return boolean
	 */
	public function allows($action, $context = null)
	{
		$user = $this->forUser ?: $this->auth->user();

		// If there's no user, there are no permissions to check
		if ( ! $user) return false;

		// If the rule is not found, there's probably a developer error
		if ( ! $this->handler->has($action)) throw new Exceptions\RuleNotFoundException(
			"'{$action}' is not a registered rule"
		);

		// Otherwise, get the rule and check permissions for user in context
		return $this->handler->get($action)->validFor($user, $context);
	}

	/**
	 * Check if the reverse of allows() is true
	 *
	 * @param  string  $action
	 * @param  mixed  $context
	 * @return boolean
	 */
	public function disallows($rule, $context = null)
	{
		return ! $this->allows($rule, $context);
	}
}
