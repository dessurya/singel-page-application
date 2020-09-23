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

	public function getAnswerReport($data){
		if (TransactionDetils::where([
			'profilling' => $data['profilling'], 
			'answer' => $data['answer'], 
			'question' => $data['question'], 
			'criteria' => $data['criteria'], 
			'transaction'=>$data['transaction']
			])->count() > 0) {
			return true;
		}else{
			return false;
		}
	}
}
