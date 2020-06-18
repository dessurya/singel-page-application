<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profilling extends Model
{
	protected $table = 'prof_profilling';

	public function getAnswer(){
		return $this->hasOne('App\Model\Answer', 'id', 'answer');
	}
}
