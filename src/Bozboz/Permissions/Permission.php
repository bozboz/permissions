<?php

namespace Bozboz\Permissions;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	protected $fillable = [
		'action',
		'param'
	];

	public function label()
	{
		$label = $this->action;

		if ($this->param) {
			$label .= ' [' . $this->param . ']';
		}

		return $label;
	}
}
