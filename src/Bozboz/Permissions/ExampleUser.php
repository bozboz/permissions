<?php

namespace Bozboz\Permissions;

use Illuminate\Database\Eloquent\Model;

class ExampleUser extends Model implements UserInterface
{
	protected $table = 'users';
	protected $fillable = [
		'first_name',
		'last_name'
	];

	public function permissions()
	{
		return $this->hasMany(Permission::class, 'user_id');
	}

	public function getPermissions($action, $param = null)
	{
		$this->permissions;
	}
}
