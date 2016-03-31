<?php

namespace Bozboz\Permissions;

trait EloquentPermissionsTrait
{
	public function getPermissions()
	{
		return $this->permissions;
	}

	public function permissions()
	{
		return $this->hasMany(Permission::class, 'user_id');
	}

	public function grantPermission($action, $param = null)
	{
		$attributes = compact('action', 'param');

		if ($this->permissions()->where($attributes)->count() === 0) {
			$this->permissions()->create($attributes);
		}
	}

	public function grantWildcard()
	{
		$this->grantPermission(Permission::WILDCARD);
	}

	public function revokePermission($action, $param = null)
	{
		$this->permissions()->whereAction($action)->whereParam($param)->delete();
	}

	public function scopeHasPermission($builder, $action)
	{
		$builder->whereHas('permissions', function($q) use ($action) {
			$q->where(function($q) use ($action) {
				$q->where('action', $action)
				  ->orWhere('action', Permission::WILDCARD);
			});
		});
	}

	public function scopeDoesntHavePermission($builder, $action)
	{
		$builder->whereDoesntHave('permissions', function($q) use ($action) {
			$q->where(function($q) use ($action) {
				$q->where('action', $action)
				  ->orWhere('action', Permission::WILDCARD);
			});
		});
	}
}
