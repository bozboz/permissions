<?php

namespace Bozboz\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
	public function register()
	{
		$this->app->bindShared('permission.handler', function($app)
		{
			return new Handler;
		});

		$this->app->bind('Bozboz\Permissions\Handler', 'permission.handler');

		$this->app->bind('permission.checker', function($app)
		{
			return new Checker($app['permission.handler'], $app['auth']);
		});
	}

	public function boot()
	{
		$permissions = $this->app['permission.handler'];

		if ($this->app['files']->exists('permissions.php')) {
			include app_path('permissions.php');
		}
	}
}
