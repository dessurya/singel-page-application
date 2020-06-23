<?php

namespace App\Repositories;

use Auth;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use App\Repositories\Interfaces\ActionRepositoryInterface;

use App\Model\Config;
use App\Model\Master;
use App\Model\Role;
use App\Model\User;
use App\Model\UserDetils;
use App\Model\Question;
use App\Model\Answer;
use App\Model\Competencies;
use App\Model\Profilling;
use App\Model\VpProfilling;
use App\Model\Transaction;
use App\Model\TransactionDetils;

class ActionRepository implements ActionRepositoryInterface{

	public function action($data){
		if ($data['input']['data']['acckey'] == 'change_password' and $data['input']['data']['action'] == 'change_password' and $data['input']['data']['store'] == true) {
			return $this->change_password_store($data);
		}else if ($data['input']['data']['acckey'] == 'indexOfSearch' and $data['input']['data']['action'] == 'indexOfSearch') {
			return $this->indexOfSearch($data);
		}else if ($data['input']['data']['acckey'] == 'indexOfSearchProcess' and $data['input']['data']['action'] == 'indexOfSearchProcess') {
			return $this->indexOfSearchProcess($data);
		}else if ($data['input']['data']['acckey'] == 'takeProfilling' and $data['input']['data']['action'] == 'takeProfilling') {
			return $this->takeProfilling($data);
		}

		$accChecking = $this->checkAccess($data['input']['data']);
		if ($accChecking == false) { return [ 'Success' => false, 'note' => 'Access denied' ]; }
		$funct = $data['input']['data']['acckey'].'_'.$data['input']['data']['action'];
		if (isset($data['input']['data']['store']) and $data['input']['data']['store'] == true) {
			$funct .= '_store';
		}
		// return $funct;
		$exeFunct = $this->getFunct($funct);
		return $respon = $this->$exeFunct($data);
	}

	private function takeProfilling($data){
		$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
		$me = User::find(Auth::guard('user')->user()->id);

		$head = new Transaction;
		$head->email = $me->email;
		$head->name = $me->name;
		$head->phone = $me->getUserDetils->phone;
		$head->consultant = null;
		$head->user_id = $me->id;
		$head->save();

		foreach ($storeData as $key => $value) {
			if (strpos($key, 'question') !== false and !strpos($key, 'HiddenCheck')) {
				$profilling = Profilling::find($value);
				$detils = new TransactionDetils;
				$detils->transaction = $head->id;
				$detils->profilling = $profilling->id;
				$detils->question = $profilling->question;
				$detils->answer = $profilling->answer;
				$detils->competencies = $profilling->competencies;
				$detils->save();
			}
		}

		$query = "
			SELECT
				prof_competencies.competencies AS competencies,
				count
			FROM(
				SELECT 
					competencies,
					count(competencies) as count
				FROM
					prof_transaction_detils ptd
				WHERE
					transaction = ^idOfTransaction^
				GROUP BY
					competencies
			) trs
			LEFT JOIN
				prof_competencies on trs.competencies = prof_competencies.id
			ORDER BY count DESC
		";
		$query = str_replace(['^idOfTransaction^'], [$head->id], $query);
		$getCompetenciesResault = DB::select(DB::raw($query));

		$head->competencies = $getCompetenciesResault[0]->competencies;
		$head->result = json_encode([
			'competencies' => $getCompetenciesResault
		]);
		$head->save();

		return [
			"Success" => true,
			"reloadTable" => false,
			"responseType" => "storeFormData",
			"info" => "Success"
		];
	}

	private function indexOfSearch($data){
		$access = [];
		$config = Config::where('accKey',$data['input']['data']['storeData']['type'])->first();
		$access['title'] = str_replace('profilling', '', $data['input']['data']['storeData']['type']);
		$access['config'] = json_decode($config->config, true);
		$access['actionBuild'] = false;
		$access['dataTabOfId'] = 'table-data1';
		$access['content'] = base64_encode(view('_layout.content.content', compact('access'))->render());
		$access['responseType'] = 'indexOfSearch';
		$access['config'] = base64_encode(json_encode($access['config']));
		return $access;
	}

	private function indexOfSearchProcess($data){
		$access = [];
		$config = Config::where('accKey',$data['input']['data']['storeData']['type'])->first();
		$config = json_decode($config->config, true);
		$Model = "App\Model\\".$config['table']['url'];
		$get = $Model::where('id',$data['input']['data']['storeData']['id'])->get();
		$get = $get[0];
		return [
			'responseType' => 'indexOfSearchResponse',
			'type' => $data['input']['data']['storeData']['type'],
			'dataId' => $get['id'],
			'valOfField' => $get[$config['table']['valOfField']]
		];
	}

	private function change_password_store($data){
		$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
		if (!isset($storeData['old_password'])) {
			$storeData['old_password'] = null;
		}
		$me = User::find(Auth::guard('user')->user()->id);

    	if(empty($me->password) or Hash::check($storeData['old_password'], $me->password)){
			if ($storeData['new_password'] == $storeData['cnfrm_password']) {
				$me->password = Hash::make($storeData['new_password']);
				$me->save();
				return [
					"Success" => true,
					"reloadTable" => false,
					"responseType" => "refresh",
					"info" => "Success!"
				];
			}else{
				return [
					"Success" => true,
					"reloadTable" => false,
					"reloadForm" => false,
					"responseType" => "storeFormData",
					"info" => "New Password and Confirm Password not same"
				];
			}
		}
		else{
			return [
				"Success" => true,
				"reloadTable" => false,
				"reloadForm" => false,
				"responseType" => "storeFormData",
				"info" => "Old Password not valid"
			];
		}
	}

	// public
		private function getFunct($key){
			if (in_array($key, ['masterMarital_add', 'masterReligion_add', 'masterIndustry_add', 'masterLevel_add', 'masterEducation_add', 'masterCompetencies_add', 'masterMarital_view', 'masterReligion_view', 'masterIndustry_view', 'masterLevel_view', 'masterEducation_view', 'masterCompetencies_view'])) {
				return 'masterForm';
			}else if (in_array($key, ['masterMarital_add_store', 'masterReligion_add_store', 'masterIndustry_add_store', 'masterLevel_add_store', 'masterEducation_add_store', 'masterCompetencies_add_store', 'masterMarital_edit_store', 'masterReligion_edit_store', 'masterIndustry_edit_store', 'masterLevel_edit_store', 'masterEducation_edit_store', 'masterCompetencies_edit_store'])) {
				return 'masterStore';
			}else if (in_array($key, ['masterMarital_Activated/Inactivated', 'masterReligion_Activated/Inactivated', 'masterIndustry_Activated/Inactivated', 'masterLevel_Activated/Inactivated', 'masterEducation_Activated/Inactivated', 'masterCompetencies_Activated/Inactivated'])) {
				return 'masterActivatedInactivated';
			}else if (in_array($key, ['uarUser_add','uarUser_view'])) {
				return 'uarUserForm';
			}else if (in_array($key, ['uarUser_add_store','uarUser_edit_store'])) {
				return 'uarUserStore';
			}else if (in_array($key, ['uarUser_Activated/Inactivated'])) {
				return 'uarUserActivatedInactivated';
			}else if (in_array($key, ['uarAdmin_add', 'uarAdmin_view'])) {
				return 'uarAdminForm';
			}else if (in_array($key, ['uarAdmin_add_store', 'uarAdmin_edit_store'])) {
				return 'uarAdminStore';
			}else if (in_array($key, ['uarAdmin_Activated/Inactivated'])) {
				return 'uarAdminActivatedInactivated';
			}else if (in_array($key, ['uarRole_add', 'uarRole_view'])) {
				return 'uarRoleForm';
			}else if (in_array($key, ['uarRole_add_store', 'uarRole_edit_store'])) {
				return 'uarRoleStore';
			}else if (in_array($key, ['uarRole_Activated/Inactivated'])) {
				return 'uarRoleActivatedInactivated';
			}else if (in_array($key, ['profillingQuestion_add','profillingQuestion_view'])) {
				return 'profillingQuestionForm';
			}else if (in_array($key, ['profillingQuestion_add_store', 'profillingQuestion_edit_store'])) {
				return 'profillingQuestionStore';
			}else if (in_array($key, ['profillingQuestion_Activated/Inactivated'])) {
				return 'profillingQuestionActivatedInactivated';
			}else if (in_array($key, ['profillingAnswer_add','profillingAnswer_view'])) {
				return 'profillingAnswerForm';
			}else if (in_array($key, ['profillingAnswer_add_store', 'profillingAnswer_edit_store'])) {
				return 'profillingAnswerStore';
			}else if (in_array($key, ['profillingAnswer_Activated/Inactivated'])) {
				return 'profillingAnswerActivatedInactivated';
			}else if (in_array($key, ['profillingCompetencies_add','profillingCompetencies_view'])) {
				return 'profillingCompetenciesForm';
			}else if (in_array($key, ['profillingCompetencies_add_store', 'profillingCompetencies_edit_store'])) {
				return 'profillingCompetenciesStore';
			}else if (in_array($key, ['profillingCompetencies_Activated/Inactivated'])) {
				return 'profillingCompetenciesActivatedInactivated';
			}else if (in_array($key, ['profilling_add','profilling_view'])) {
				return 'profillingForm';
			}else if (in_array($key, ['profilling_add_store', 'profilling_edit_store'])) {
				return 'profillingStore';
			}else if (in_array($key, ['profilling_Activated/Inactivated'])) {
				return 'profillingActivatedInactivated';
			}else if (in_array($key, ['selfUpdate_edit_store'])) {
				return 'uarUserStore';
			}else if (in_array($key, ['transaction_view', 'selfProfillingHistory_view'])) {
				return 'transactionView';
			}else if (in_array($key, ['transaction_revision/finalise_store'])) {
				return 'transactionStore';
			}else if (in_array($key, ['profilling_upload'])) {
				return 'profillingUpload';
			}else if (in_array($key, ['uarUser_upload'])) {
				return 'uarUserUpload';
			}
		}

		private function callForm($data, $reloadTable = false){
			return [
				"responseType" => "callForm",
				"reloadTable" => $reloadTable,
				"callForm" => base64_encode($data)
			];
		}

		private function checkAccess($data){
			$access = json_decode(base64_decode($data['access']),true);
			if (array_key_exists($data['acckey'],$access) and $access[$data['acckey']][$data['action']] == true){
				return true;
			}
			return false;
		}

		private function convert_to_akv($data){
			$arr = [];
			foreach ($data as $val) {
				$arr[$val['name']] = $val['value'];
			}
			return $arr;
		}

		private function readExcelFile($data){
			$file         = explode('/', $data['path']);
	        $file         = Carbon::now()->format('Ymd_h_i_s').$file[count($file)-1];
	        $file_dir     = 'import_doc/'.$file.'.xlsx';
			$data['decoded_file'] = base64_decode($data['decoded_file']); // decode the file
	        try {
	          file_put_contents($file_dir, $data['decoded_file']);
	          $response = true;
	        } catch (Exception $e) {
	          $response = $e->getMessage();
	        }
	        $objPHPExcel = IOFactory::load($file_dir);
	        $sheet = $objPHPExcel->getSheet(0);
	        $highestRow = $sheet->getHighestRow();
	        $highestColumn = $sheet->getHighestColumn();
	        $highestColumn++;
	        $header = [];
	        for ($column = 'A'; $column != $highestColumn; $column++) {
	        	$cell = $sheet->getCell($column.'1')->getValue();
	        	$header[] = $cell;
	        }
	        return ['sheet' => $sheet, 'highestRow' => $highestRow, 'header' => $header, 'file_dir' => $file_dir];

		}
	// public


	// uarUser
		private function uarUserForm($data){
			$var = [];
			$var['User'] = null;
			$var['Detils'] = null;
			$var['Education'] = Master::where([ 'type' => 'education', 'status' => 'Y' ])->get();
			$var['Industry'] = Master::where([ 'type' => 'Industry', 'status' => 'Y' ])->get();
			$var['Level'] = Master::where([ 'type' => 'level', 'status' => 'Y' ])->get();
			$var['Marital'] = Master::where([ 'type' => 'marital', 'status' => 'Y' ])->get();
			$var['Religion'] = Master::where([ 'type' => 'religion', 'status' => 'Y' ])->get();
			$var['Competencies'] = Master::where([ 'type' => 'competencies', 'status' => 'Y' ])->get();
			$title = 'Add User';
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var['User'] = User::find($data['input']['id']);
				$var['Detils'] = UserDetils::where('user_id',$data['input']['id'])->first();
				$title = 'View User';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit User';
					$action = 'edit';
				}
			}
			$html = view('_main.uarUser.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function uarUserStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);

			if (empty($storeData['id'])) {
				$check = User::where('email', $storeData['email'])->count();
			}else{
				$check = User::where('email', $storeData['email'])->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Email Sudah terdaftar!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new User;
				$remember_token = Str::random(32);
				$store->remember_token = $remember_token;
			}else{
				$store = User::find($storeData['id']);
			}

			$store->name = $storeData['name'];
			$store->email = $storeData['email'];
			$store->roll_id = 2;
			$store->save();

			$store2 = UserDetils::where('user_id',$store->id)->first();
			if (empty($store2)) {
				$store2 = new UserDetils;
				$store2->user_id = $store->id;
			}
			$store2->date_of_birth = $storeData['date_of_birth'];
			$store2->phone = $storeData['phone'];
			$store2->gender = $storeData['gender'];
			$store2->religion = $storeData['religion'];
			$store2->marital_status = $storeData['marital_status'];
			$store2->education = $storeData['education'];
			$store2->project_name = $storeData['project_name'];
			$store2->project_code = $storeData['project_code'];
			$store2->group_cos = $storeData['group_cos'];
			$store2->current_companies = $storeData['current_companies'];
			$store2->industry = $storeData['industry'];
			$store2->work_title = $storeData['work_title'];
			$store2->level = $storeData['level'];
			$store2->competencies = $storeData['competencies'];
			$store2->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function uarUserActivatedInactivated($data){
			$store = User::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function uarUserUpload($data){
			$checkHeader = Config::where('accKey', 'uarUser')->first();
			$checkHeader = json_decode($checkHeader->config, true);
			$checkHeader = $checkHeader['templateCheck'];
			$read = $this->readExcelFile([
	        	'path' => $data['input']['data']['acckey'],
	        	'decoded_file' => $data['input']['data']['base64'] 
	        ]);
	        if ($read['header'] !== $checkHeader) {
	        	unlink($read['file_dir']);
	        	return [
	        		"Success" => false,
	        		"responseType" => "notif",
	        		"info" => "Sorry, this not correct document"
	        	];
	        }
	        $result = [];
	        $result['true'] = [];
	        $result['false'] = [];
	        for ($row = 2; $row <= $read['highestRow']; $row++){
	        	$sheet = $read['sheet'];
	        	$data = [
	        		"name" => $sheet->getCell('A'.$row)->getValue(),
	        		"email" => $sheet->getCell('B'.$row)->getValue(),
	        		"date_of_birth" => $sheet->getCell('C'.$row)->getValue(),
	        		"phone" => $sheet->getCell('D'.$row)->getValue(),
	        		"gender" => $sheet->getCell('E'.$row)->getValue(),
	        		"religion" => $sheet->getCell('F'.$row)->getValue(),
	        		"marital_status" => $sheet->getCell('G'.$row)->getValue(),
	        		"education" => $sheet->getCell('H'.$row)->getValue(),
	        		"project_code" => $sheet->getCell('I'.$row)->getValue(),
	        		"project_name" => $sheet->getCell('J'.$row)->getValue(),
	        		"group_cos" => $sheet->getCell('K'.$row)->getValue(),
	        		"current_companies" => $sheet->getCell('L'.$row)->getValue(),
	        		"industry" => $sheet->getCell('M'.$row)->getValue(),
	        		"work_title" => $sheet->getCell('N'.$row)->getValue(),
	        		"level" => $sheet->getCell('O'.$row)->getValue(),
	        		"competencies" => $sheet->getCell('P'.$row)->getValue(),
	        		"status" => $sheet->getCell('Q'.$row)->getValue()
	        	];
	        	$store = $this->uarUserUploadStore($data);
	        	if ($store['Success'] == true) { $result['true'][] = $data; }
	        	else if ($store['Success'] == false) { 
	        		$data['info'] = $store['info'];
	        		$result['false'][] = $data;
	        	}
	        }
	        unlink($read['file_dir']);
	        $html = view('_main.uarUser.import', compact('result'))->render();
			return $this->callForm($html, true);
		}

		private function uarUserUploadStore($data){
			if (!in_array($data['gender'], ['Male','Female'])) {
				return ['Success' => false, 'info' => 'Gender not in Male or Female'];
			}else if (User::where('email',$data['email'])->count() >= 1) {
				return ['Success' => false, 'info' => 'Email alerdy exists'];
			}
			$remember_token = Str::random(32);
			$store = new User;
			$store->remember_token = $remember_token;
			$store->name = $data['name'];
			$store->email = $data['email'];
			$store->status = $data['status'];
			$store->roll_id = 2;
			$store->save();
			$store2 = UserDetils::where('user_id',$store->id)->first();
			$store2 = new UserDetils;
			$store2->user_id = $store->id;
			$store2->date_of_birth = $data['date_of_birth'];
			$store2->phone = $data['phone'];
			$store2->gender = $data['gender'];
			$store2->religion = $data['religion'];
			$store2->marital_status = $data['marital_status'];
			$store2->education = $data['education'];
			$store2->project_name = $data['project_name'];
			$store2->project_code = $data['project_code'];
			$store2->group_cos = $data['group_cos'];
			$store2->current_companies = $data['current_companies'];
			$store2->industry = $data['industry'];
			$store2->work_title = $data['work_title'];
			$store2->level = $data['level'];
			$store2->competencies = $data['competencies'];
			$store2->save();
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'competencies', 'value' => $data['competencies'] ]);
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'education', 'value' => $data['education'] ]);
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'industry', 'value' => $data['industry'] ]);
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'level', 'value' => $data['level'] ]);
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'marital', 'value' => $data['marital_status'] ]);
			$this->uarUserUploadStoreCheckMaster([ 'type' => 'religion', 'value' => $data['religion'] ]);
			return ['Success' => true];
		}

		private function uarUserUploadStoreCheckMaster($data){
			$condtion = [
				'type' => $data['type'],
				'value' => preg_replace("/[^A-Za-z0-9 ]/", '', $data['value'])
			];
			$check = Master::where($condtion)->count();
			if ($check == 0) { 
				$store = new Master;
				$store->type = $data['type'];
				$store->value = $data['value'];
				$store->status = 'Y';
				$store->save();
			}
		}
	// uarUser

	// uarAdmin
		private function uarAdminForm($data){
			$var = [];
			$var['Admin'] = null;
			$var['Role'] = Role::where([ 'status' => 'Y' ])->whereNotIn('id', [2])->get();
			$title = 'Add Admin';
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var['Admin'] = User::find($data['input']['id']);
				$title = 'View Admin';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit Admin';
					$action = 'edit';
				}
			}
			$html = view('_main.uarAdmin.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		public function uarAdminStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);

			if (empty($storeData['id'])) {
				$check = User::where('email', $storeData['email'])->count();
			}else{
				$check = User::where('email', $storeData['email'])->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Email Sudah terdaftar!"
				];
			}
			if (empty($storeData['id'])) {
				$remember_token = Str::random(32);
				$store = new User;
				$store->status = 'N';
				$store->remember_token = $remember_token;
			}else{
				$store = User::find($storeData['id']);
			}

			$store->name = $storeData['name'];
			$store->email = $storeData['email'];
			$store->roll_id = $storeData['role'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function uarAdminActivatedInactivated($data){
			if (Auth::guard('user')->user()->id == $data['input']['data']['id']) {
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Tidak dapat merubah data sendiri!"
				];
			}
			$store = User::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// uarAdmin

	// uarRole
		private function uarRoleForm($data){
			$json = '';
			$var = [];
			$var['Role'] = null;
			$var['Access'] = $this->group_access_for_role_form();
			$title = 'Add Role';
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				if (in_array($data['input']['id'], [1,2])) {
					return [
						"Success" => false,
						"responseType" => "storeFormData",
						"info" => "Merupakan data master tidak diperbolehkan untuk diubah!"
					];
				}
				$role = Role::find($data['input']['id']);
				$var['Role'] = $role;
				$var['AccessMenu'] = json_decode($role->access_menu, true);
				$title = 'View Role';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit Role';
					$action = 'edit';
				}
			}
			$html = view('_main.uarRole.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		public function uarRoleStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);

			if (empty($storeData['id'])) {
				$check = Role::where('name', $storeData['name'])->count();
			}else{
				if (in_array($storeData['id'], [1,2])) {
					return [
						"Success" => false,
						"responseType" => "storeFormData",
						"info" => "Merupakan data master tidak diperbolehkan untuk diubah!"
					];
				}
				$check = Role::where('name', $storeData['name'])->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data sudah ada!"
				];
			}

			if (empty($storeData['id'])) {
				$store = new Role;
				$store->status = 'N';
			}else{
				$store = Role::find($storeData['id']);
			}
			$store->name = $storeData['name'];
			$store->access_menu = json_encode($this->buildAccessJson($storeData));
			$store->save();

			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function buildAccessJson($data){
			$accKey = $this->getAccKey($data);
			$menu = $this->getMenu($accKey);
			return [
				"menu" => $menu,
				"accKey" => $accKey
			];
		}

		private function getAccKey($data){
			$newArr = [];
			foreach ($data as $key => $value) {
				if(strpos($key, '^#^') !== false){
					$getKey = explode('^#^', $key);
					$newArr[$getKey[0]][$getKey[1]] = $value;
				}
			}
			return $newArr;
		}

		private function getMenu($data){
			$accKey = [];
			foreach ($data as $key => $value) {
				if (array_key_exists('view',$value) and $value['view'] == true){
					$accKey[] = $key;
				}
			}
			$configMenu = $this->group_access_for_role_form();
			$menu = [];
			foreach ($configMenu['group_access'] as $group) {
				$tab = [];
				foreach ($group['access_key'] as $trgt) {
					if (in_array($trgt['key'], $accKey)) {
						$tab['chld'] = [];
						$tab['name'] = $group['name'];
						$tab['tab'] = $group['tab'];
						$tab['chld'][] = [
							'name' => $trgt['name'],
							'accKey' => $trgt['key']
						];
					}
				}
				if (!empty($tab)) {
					$menu[] = $tab;
				}
			}
			return $menu;
		}

		private function group_access_for_role_form(){
			$configAcc = Config::where('accKey','group_access_for_role_form')->first();
		    return $configAcc = json_decode($configAcc->config, true);
		}

		private function uarRoleActivatedInactivated($data){
			if (in_array($data['input']['data']['id'], [1,2])) {
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Merupakan data master tidak diperbolehkan untuk diubah!"
				];
			}
			$store = Role::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// uarAdmin

	// master
		private function masterForm($data){
			$var = null;
			$title = 'Add';
			$type = str_replace('master', '', $data['input']['data']['acckey']);
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = Master::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.master.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function masterStore($data){
			$acckey = $data['input']['data']['acckey'];
			$type = strtolower(str_replace('master', '', $acckey));
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'type' => $type,
				'value' => preg_replace("/[^A-Za-z0-9 ]/", '', $storeData['value'])
			];
			if (empty($storeData['id'])) {
				$check = Master::where($condtion)->count();
			}else{
				$check = Master::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Master;
			}else{
				$store = Master::find($storeData['id']);
			}
			$store->type = $type;
			$store->value = $storeData['value'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function masterActivatedInactivated($data){
			$store = Master::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// master

	// profillingQuestion
		private function profillingQuestionForm($data){
			$var = null;
			$title = 'Add';
			$type = str_replace('profilling', '', $data['input']['data']['acckey']);
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = Question::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.profillingQuestion.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function profillingQuestionStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'question' => $storeData['question']
			];
			if (empty($storeData['id'])) {
				$check = Question::where($condtion)->count();
			}else{
				$check = Question::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Question;
			}else{
				$store = Question::find($storeData['id']);
			}
			$store->question = $storeData['question'];
			$store->criteria = $storeData['criteria'];
			$store->sort = $storeData['sort'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingQuestionActivatedInactivated($data){
			$store = Question::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// profillingQuestion

	// profillingAnswer
		private function profillingAnswerForm($data){
			$var = null;
			$title = 'Add';
			$type = str_replace('profilling', '', $data['input']['data']['acckey']);
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = Answer::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.profillingAnswer.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function profillingAnswerStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'answer' => $storeData['answer']
			];
			if (empty($storeData['id'])) {
				$check = Answer::where($condtion)->count();
			}else{
				$check = Answer::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Answer;
			}else{
				$store = Answer::find($storeData['id']);
			}
			$store->answer = $storeData['answer'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingAnswerActivatedInactivated($data){
			$store = Answer::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// profillingAnswer

	// profillingCompetencies
		private function profillingCompetenciesForm($data){
			$var = null;
			$title = 'Add';
			$type = str_replace('profilling', '', $data['input']['data']['acckey']);
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = Competencies::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.profillingCompetencies.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function profillingCompetenciesStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'competencies' => $storeData['competencies']
			];
			if (empty($storeData['id'])) {
				$check = Competencies::where($condtion)->count();
			}else{
				$check = Competencies::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Competencies;
			}else{
				$store = Competencies::find($storeData['id']);
			}
			$store->competencies = $storeData['competencies'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingCompetenciesActivatedInactivated($data){
			$store = Competencies::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// profillingCompetencies

	// profilling
		private function profillingForm($data){
			$var = null;
			$title = 'Add';
			$type = $data['input']['data']['acckey'];
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = VpProfilling::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.profilling.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function profillingStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'question' => $storeData['questionId'],
				'answer' => $storeData['answerId'],
				'competencies' => $storeData['competenciesId']
			];
			if (empty($storeData['id'])) {
				$check = Profilling::where($condtion)->count();
			}else{
				$check = Profilling::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Profilling;
			}else{
				$store = Profilling::find($storeData['id']);
			}
			$store->question = $storeData['questionId'];
			$store->answer = $storeData['answerId'];
			$store->competencies = $storeData['competenciesId'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingActivatedInactivated($data){
			$store = Profilling::find($data['input']['data']['id']);
			if ($store->status == 'N') { $store->status = 'Y'; }
			else { $store->status = 'N'; }
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingUpload($data){
			$checkHeader = Config::where('accKey', 'profilling')->first();
			$checkHeader = json_decode($checkHeader->config, true);
			$checkHeader = $checkHeader['templateCheck'];
			$read = $this->readExcelFile([
	        	'path' => $data['input']['data']['acckey'],
	        	'decoded_file' => $data['input']['data']['base64'] 
	        ]);
	        if ($read['header'] !== $checkHeader) {
	        	unlink($read['file_dir']);
	        	return [
	        		"Success" => false,
	        		"responseType" => "notif",
	        		"info" => "Sorry, this not correct document"
	        	];
	        }
	        $result = [];
	        $result['true'] = [];
	        $result['false'] = [];
	        for ($row = 2; $row <= $read['highestRow']; $row++){
	        	$sheet = $read['sheet'];
	        	$data = [
	        		"criteria" => $sheet->getCell('A'.$row)->getValue(),
	        		"question" => $sheet->getCell('B'.$row)->getValue(),
	        		"answer" => $sheet->getCell('C'.$row)->getValue(),
	        		"competencies" => $sheet->getCell('D'.$row)->getValue(),
	        		"status" => $sheet->getCell('E'.$row)->getValue()
	        	];
	        	$store = $this->profillingUploadStore($data);
	        	if ($store == true) { $result['true'][] = $data; }
	        	else if ($store == false) { $result['false'][] = $data; }
	        }
	        unlink($read['file_dir']);
	        $html = view('_main.profilling.import', compact('result'))->render();
			return $this->callForm($html, true);
		}

		private function profillingUploadStore($data){
			$GetQuestion = $this->profillingUploadStoreGetComponen([
				'model' => 'App\Model\Question',
				'store' => ['criteria' => $data['criteria'], 'question' => $data['question']]
			]);
			$GetAnswer = $this->profillingUploadStoreGetComponen([
				'model' => 'App\Model\Answer',
				'store' => ['answer' => $data['answer']]
			]);
			$GetCompetencies = $this->profillingUploadStoreGetComponen([
				'model' => 'App\Model\Competencies',
				'store' => ['competencies' => $data['competencies']]
			]);
			$storeData = [
				'competencies' => $GetCompetencies,
				'answer' => $GetAnswer,
				'question' => $GetQuestion
			];
			$cekOld = Profilling::where($storeData)->first();
			if (!empty($cekOld)) {
				return false;
			}else{
				$storeData['status'] = $data['status'];
				Profilling::insert($storeData);
				return true;
			}
		}

		private function profillingUploadStoreGetComponen($data){
			$ModelD = $data['model'];
			$cekOld = $ModelD::where($data['store'])->first();
			if (!empty($cekOld)) { return $cekOld->id; }
			else { 
				$data['store']['status'] = 'Y';
				return $store = $ModelD::insertGetId($data['store']); 
			}
		}
	// profilling

	// transaction
		private function transactionView($data){
			$var = [];
			$var['head'] = Transaction::find($data['input']['id']);
			$var['competencies'] = json_decode($var['head']->result, true);
			$var['competencies'] = $var['competencies']['competencies'];
			$var['detl'] = TransactionDetils::where('transaction',$data['input']['id'])->get();
			$type = $data['input']['data']['acckey'];
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			$access = json_decode(base64_decode($data['input']['data']['access']),true);
			if (Auth::guard('user')->user()->roll_id != 2 and array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['revision/finalise'] == true and $var['head']->status == 'Pending'){
				$action = 'revision/finalise';
			}
			$title = 'View '.$type;

			$html = view('_main.transaction.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function transactionStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			if ($storeData['rf'] == 'revision' and empty($storeData['note'])) {
				return [
					"Success" => false,
					"reloadForm" => false,
					"reloadTable" => false,
					"responseType" => "storeFormData",
					"info" => "Harap isi note terlebih dahulu!"
				];
			}
			$store = Transaction::find($storeData['id']);
			if ($store->status != 'Pending') {
				return [
					"Success" => false,
					"reloadForm" => false,
					"reloadTable" => false,
					"responseType" => "storeFormData",
					"info" => "Tidak bisa merubah data yang telah disimpan!"
				];
			}
			$store->status = Str::title($storeData['rf']);
			$store->note = $storeData['note'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// transaction
}
