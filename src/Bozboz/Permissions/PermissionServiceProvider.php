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
			return new Checker($app['permission.handler'], $app['auth']->driver());
		});
	}

	public function boot()
	{
		$this->package('bozboz/permissions');

		$this->includeAppPermissions();
	}

	protected function includeAppPermissions()
	{
		$file = app_path('permissions.php');

		$permissions = $this->app['permission.handler'];

		if ($this->app['files']->exists($file)) {
			include $file;
		}
	}
}
