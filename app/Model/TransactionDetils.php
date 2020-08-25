<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TransactionDetils extends Model
{
	protected $table = 'prof_transaction_detils';

	public function getTransaction(){
		return $this->hasOne('App\Model\Transaction', 'id', 'transaction');
	}

	public function getQuestion(){
		return $this->hasOne('App\Model\Question', 'id', 'question');
	}

	public function getAnswer(){
		return $this->hasOne('App\Model\Answer', 'id', 'answer');
	}

	public function getCriteria(){
		return $this->hasOne('App\Model\Criteria', 'id', 'criteria');
	}

	public function getCompetencies(){
		return $this->hasOne('App\Model\Competencies', 'id', 'competencies');
	}
}
