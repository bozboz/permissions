<?php

namespace Bozboz\Permissions;

use Illuminate\Database\Eloquent\Model;

class ExampleUser extends Model implements UserInterface
{
	use EloquentPermissionsTrait;

	protected $table = 'users';
	protected $fillable = [
		'first_name',
		'last_name'
	];
}
