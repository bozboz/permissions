<?php

namespace Bozboz\Permissions;

/**
 * Note, this class is a test class, used for demonstrating various rules
 */
class Declaration
{
	public $code;
	protected $callback;
	protected $executed = false;
	protected $result;

	public function __construct($rule, $callback)
	{
		$this->code = $rule;
		$this->callback = $callback;
	}

	/**
	 * Execute the passed callback and store the result. If an exception is
	 * thrown, catch it and return a notification of the error as the result
	 *
	 * @param  Bozboz\Permissions\Checker  $permissions
	 * @return mixed
	 */
	public function execute($permissions)
	{
		if ($this->executed) return $this->result;

		try {
			$this->result = call_user_func($this->callback, $permissions);
		} catch (\Exception $e) {
			$this->result = sprintf('EXCEPTION: %s (%s)', get_class($e), $e->getMessage());
		} finally {
			$this->executed = true;
		}

		return $this->result;
	}
}
