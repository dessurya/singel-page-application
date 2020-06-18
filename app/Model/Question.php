<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $table = 'prof_question';

	public function getChoice(){
		return $this->hasMany('App\Model\Profilling', 'question', 'id');
	}
}
