<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Profilling extends Model
{
	protected $table = 'prof_profilling';

	public function getAnswer(){
		return $this->hasOne('App\Model\Answer', 'id', 'answer');
	}

	public function getCompetencies(){
		return $this->hasOne('App\Model\Competencies', 'id', 'competencies');
	}

	public function getAnswerReport($profilling,$answer,$trans){
		if (TransactionDetils::where(['profilling' => $profilling, 'answer' => $answer, 'transaction'=>$trans])->count() > 0) {
			return 'X';
		}else{
			return '';
		}
	}
}
