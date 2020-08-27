<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Question;
use App\Model\Profilling;
use App\Model\TransactionDetils;

class DashboardController extends Controller{
    public function index(){
		return view('_main.dashboard.index');
	}

	public static function getQuestion($trans,$criteria)
	{
		return TransactionDetils::with('getQuestion')
		->where([
			'transaction'=>$trans,
			'criteria'=>$criteria
		])->orderBy('question','asc')->get();
	}

	public static function getCompetencies($criteria,$question)
	{
		return Profilling::with('getCompetencies')->where([
			'criteria'=>$criteria,
			'question'=>$question
		])->orderBy('competencies','asc')->get();
	}

	public static function getAnswer($criteria,$question,$competencies,$old)
	{
		return Profilling::with('getAnswer')->where([
			'criteria'=>$criteria,
			'question'=>$question,
			'competencies'=>$competencies
		])->whereNotIn('id',$old)->orderBy('answer','asc')->get();
	}
}
