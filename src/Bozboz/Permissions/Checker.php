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
	 * Retrieve an array of parameters for a registered rule
	 *
	 * @param  string  $action
	 * @return array
	 */
	public function getParams($action)
	{
		$user = $this->getAuthedUser();

		return $user ? $this->getRuleFromAction($action)->getParams($user) : false;
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
		$user = $this->getAuthedUser();

		return $user ? $this->getRuleFromAction($action)->validFor($user, $context) : false;
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

	/**
	 * Get the authenticated user
	 *
	 * @return Bozboz\Permissions\UserInterface
	 */
	protected function getAuthedUser()
	{
		return $this->forUser ?: $this->auth->user();
	}

	/**
	 * Retrieve Rule object based on name
	 *
	 * @param  string  $action
	 * @throws Bozboz\Permissions\Exceptions\RuleNotFoundException
	 * @return Bozboz\Permissions\Rules\Rule
	 */
	protected function getRuleFromAction($action)
	{
		// If the rule is not found, there's probably a developer error
		if ( ! $this->handler->has($action)) throw new Exceptions\RuleNotFoundException(
			"'{$action}' is not a registered rule"
		);

		// Otherwise, get the rule and check permissions for user in context
		return $this->handler->get($action);
	}
}
