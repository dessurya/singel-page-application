<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
	protected $table = 'prof_transaction';

	public function getUser()
	{
		return $this->hasOne('App\Model\User', 'id', 'user_id');
	}
}
