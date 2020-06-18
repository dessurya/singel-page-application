<?php

namespace App\Repositories;

use Validator;

use Illuminate\Support\Str;
use App\Model\User;
use App\Model\UserDetils;
use App\Repositories\Interfaces\UserRegistryRepositoryInterface;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Hash;


class UserRegistryRepository implements UserRegistryRepositoryInterface
{
    use AuthenticatesUsers;

    public function findById($data){
    	$user = User::find($data);
    	return [
    		'user' => $user,
    		'user_detil' => $user->getUserDetils
    	];
    }

    public function signup($data){
    	return $store = $this->storeUserData($data);
    	if ($store['Success'] == true) {
    		$store['msg'] = 'Success, login';
    		$store['remember_token'] = $store['user']->remember_token;
    		$store['user'] = null;
    	}
    	return $store;
    }

    private function storeUserData($data){
    	$validate = $this->signupValidate($data);
    	if ($validate['Success'] == false) { return $validate; }
    	$signupStoreDataPersonal = $this->signupStoreDataPersonal($data['personal_data']);
    	$this->signupStoreDataExperience($signupStoreDataPersonal, $data);
    	$result = User::find($signupStoreDataPersonal);
    	return [ 'Success' => true, 'user' => $result ];
    }

    private function signupValidate($data){
    	$message = [];
    	$respn = [ 'Success' => true ];
    	$check_personal_data = [
    		'name' => 'required',
    		'date_of_birth' => 'required|date',
    		'education' => 'required',
    		'email' => 'required|unique:prof_user,email',
    		'gender' => 'required',
    		'handphone' => 'required',
    		'marital_status' => 'required',
    		'religion' => 'required',
    	];
    	$validator = Validator::make($data['personal_data'], $check_personal_data, $message);
    	if($validator->fails()){
			$respn['Success'] = false;
			$respn['page'] = 'personal_data';
			$respn['validator'] = $validator->getMessageBag()->toArray();
			return $respn;
		}

    	$check_experience_data = [
    		'competencies' => 'required',
    		'current_companies' => 'required',
    		'group_cos' => 'required',
    		'industry' => 'required',
    		'level' => 'required',
    		'project_code' => 'required',
    		'project_name' => 'required',
    		'work_title' => 'required',
    	];
    	$validator = Validator::make($data['experience_data'], $check_experience_data, $message);
    	if($validator->fails()){
			$respn['Success'] = false;
			$respn['page'] = 'experience_data';
			$respn['validator'] = $validator->getMessageBag()->toArray();
			return $respn;
		}

		return $respn;
    }

    private function signupStoreDataPersonal($data){
	    $store = new User;
    	$remember_token = Str::random(32);
    	$store->name = $data['name'];
    	$store->email = $data['email'];
    	$store->status = 'Y';
    	$store->roll_id = 2;
    	$store->remember_token = $remember_token;
    	$store->save();
    	return $store->id;
    }

    private function signupStoreDataExperience($Personal_id,$data){
	    $store = new UserDetils;
    	$per = $data['personal_data'];
    	$exp = $data['experience_data'];
    	$store->user_id = $Personal_id;
    	$store->date_of_birth = $per['date_of_birth'];
    	$store->phone = $per['handphone'];
    	$store->gender = $per['gender'];
    	$store->religion = $per['religion'];
    	$store->marital_status = $per['marital_status'];
    	$store->education = $per['education'];
    	$store->project_name = $exp['project_name'];
    	$store->project_code = $exp['project_code'];
    	$store->group_cos = $exp['group_cos'];
    	$store->current_companies = $exp['current_companies'];
    	$store->industry = $exp['industry'];
    	$store->work_title = $exp['work_title'];
    	$store->level = $exp['level'];
    	$store->competencies = $exp['competencies'];
    	$store->save();
    }

    public function chngUserPassword($value=''){
    	$message = [];
    	$respn = [ 'reponse' => true ];
    	$check_personal_data = [
    		'old_password' => 'required',
    		'new_password' => 'required',
    		'nre_password' => 'required',
    	];
    	$validator = Validator::make($data['personal_data'], $check_personal_data, $message);
    	if($validator->fails()){
			$respn['reponse'] = false;
			$respn['page'] = 'personal_data';
			$respn['validator'] = $validator->getMessageBag()->toArray();
			return $respn;
		}
    }
}