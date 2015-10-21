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

		$this->app->bind('permission.checker', function($app)
		{
			return new Checker($app['permission.handler'], $app['auth']);
		});
	}

	public function boot()
	{
		$this->package('bozboz/permissions');

		$permissions = $this->app['permission.handler'];

		include app_path('permissions.php');
	}
}
