<?php

namespace App\Repositories;

use Auth;
use Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;
use PhpOffice\PhpSpreadsheet\IOFactory; 
use PhpOffice\PhpSpreadsheet\Reader\Html as ReaderHtmlPhpSpreadsheet;
use App\Repositories\Interfaces\ActionRepositoryInterface;

use App\Model\Config;
use App\Model\Master;
use App\Model\Role;
use App\Model\User;
use App\Model\UserDetils;
use App\Model\Criteria;
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
		}else if ($data['input']['data']['acckey'] == 'addDetilsProfilling' and $data['input']['data']['action'] == 'addDetilsProfilling') {
			return $this->addDetilsProfilling($data);
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
				$detils->criteria = $profilling->criteria;
				$detils->question = $profilling->question;
				$detils->answer = $profilling->answer;
				$detils->competencies = $profilling->competencies;
				$detils->save();
			}
		}

		Artisan::call('transProf:generateResault', [
            '--transaction' => $head->id
        ]);

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
		$config = Config::where('accKey',$data['input']['data']['storeData']['type'])->first();
		$config = json_decode($config->config, true);
		$Model = "App\Model\\".$config['table']['url'];
		
		if (!empty($data['input']['data']['storeData']['id'])) {
			$get = $Model::where('id',$data['input']['data']['storeData']['id'])->get();
		}else if (!empty($data['input']['data']['storeData']['new'])) {
			$set = [ $config['table']['valOfField'] => $data['input']['data']['storeData']['new'] ];
			$store = $Model::insertGetId($set);
			$get = $Model::where('id',$store)->get();
		}
		$get = $get[0];
		$get = json_decode(json_encode($get), true);
		$fillInput = [];
        $target = explode('|', $data['input']['data']['storeData']['target']);
        foreach ($target as $rData) {
            $rDataEx = explode('-', $rData);
            $key = $rDataEx[0];
            if (!empty($data['input']['data']['storeData']['parent'])) {
                $key = $data['input']['data']['storeData']['parent'].' '.$key;
            }
            $fillInput[] = [
                'key' => $key,
                'val' => $get[$rDataEx[1]]
            ];
        }
		return [
			'responseType' => 'indexOfSearchResponse',
			'fillInput' => $fillInput
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
				$me->password = $storeData['new_password'];
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

	private function addDetilsProfilling($data){
		$rand = Str::random(6);
		$html = view('_main.profilling.detils', compact('rand'))->render();
		return [
			"responseType" => "appendTo",
			"target" => "#storeDataProfilling table tbody",
			"content" => base64_encode($html)
		];
	}

	// public
		private function getFunct($key){
			$ret = Config::where('accKey', $key)->first();
			return $ret->config;
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
			if (!file_exists('import_doc/')){
				mkdir('import_doc/', 0777);
			}
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
			$id = explode('^', $data['input']['data']['id']);
			$stores = User::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$id = explode('^', $data['input']['data']['id']);
			$stores = User::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$id = explode('^', $data['input']['data']['id']);
			$stores = Role::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$id = explode('^', $data['input']['data']['id']);
			$stores = Master::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// master

	// profillingCriteria
		private function profillingCriteriaForm($data){
			$var = null;
			$title = 'Add';
			$type = str_replace('profilling', '', $data['input']['data']['acckey']);
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			if (!empty($data['input']['id']) and $data['input']['id'] != 'true') {
				$var = Criteria::find($data['input']['id']);
				$title = 'View';
				$access = json_decode(base64_decode($data['input']['data']['access']),true);
				if (array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['edit'] == true){
					$title = 'Edit';
					$action = 'edit';
				}
			}
			$title .= ' '.$type;

			$html = view('_main.profillingCriteria.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function profillingCriteriaStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$condtion = [
				'criteria' => $storeData['criteria']
			];
			if (empty($storeData['id'])) {
				$check = Criteria::where($condtion)->count();
			}else{
				$check = Criteria::where($condtion)->whereNotIn('id', [$storeData['id']])->count();
			}
			if ($check >= 1) { 
				return [
					"Success" => false,
					"responseType" => "storeFormData",
					"info" => "Data Sudah ada!"
				];
			}
			if (empty($storeData['id'])) {
				$store = new Criteria;
			}else{
				$store = Criteria::find($storeData['id']);
			}
			$store->criteria = $storeData['criteria'];
			$store->flag = $storeData['flag'];
			$store->description = $storeData['description'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingCriteriaActivatedInactivated($data){
			$id = explode('^', $data['input']['data']['id']);
			$stores = Criteria::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}
	// profillingCriteria

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
			$store->sort = $storeData['sort'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingQuestionActivatedInactivated($data){
			$id = explode('^', $data['input']['data']['id']);
			$stores = Question::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$id = explode('^', $data['input']['data']['id']);
			$stores = Answer::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$store->description = $storeData['description'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function profillingCompetenciesActivatedInactivated($data){
			$id = explode('^', $data['input']['data']['id']);
			$stores = Competencies::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$result = [];
	        $result['true'] = [];
	        $result['false'] = [];
			foreach ($data['input']['data']['storeData'] as $key => $storeData) {
				$condtion = [
					'criteria' => $storeData['criteriaId'],
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
					$result['false'][] = $storeData;
				}else{
					if (empty($storeData['id'])) {
						$store = new Profilling;
					}else{
						$store = Profilling::find($storeData['id']);
					}
					$store->criteria = $storeData['criteriaId'];
					$store->question = $storeData['questionId'];
					$store->answer = $storeData['answerId'];
					$store->competencies = $storeData['competenciesId'];
					$store->save();
					$result['true'][] = $storeData;
				}
			}
			$html = view('_main.profilling.import', compact('result'))->render();
			return $this->callForm($html, true);
		}

		private function profillingActivatedInactivated($data){
			$id = explode('^', $data['input']['data']['id']);
			$stores = Profilling::whereIn('id',$id)->get();
			foreach ($stores as $store) {
				if ($store->status == 'N') { $store->status = 'Y'; }
				else { $store->status = 'N'; }
				$store->save();
			}
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
			$GetCriteria = $this->profillingUploadStoreGetComponen([
				'model' => 'App\Model\Criteria',
				'store' => ['criteria' => $data['criteria']]
			]);
			$GetQuestion = $this->profillingUploadStoreGetComponen([
				'model' => 'App\Model\Question',
				'store' => ['question' => $data['question']]
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
				'criteria' => $GetCriteria,
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
			$var['result'] = json_decode($var['head']->result, true);
			$var['detl'] = TransactionDetils::where('transaction',$data['input']['id'])->get();
			$type = $data['input']['data']['acckey'];
			$action = $data['input']['data']['action'];
			$acckey = $data['input']['data']['acckey'];
			$access = json_decode(base64_decode($data['input']['data']['access']),true);
			if (Auth::guard('user')->user()->roll_id != 2 and array_key_exists($data['input']['data']['acckey'],$access) and $access[$data['input']['data']['acckey']]['revision/finalise'] == true){
				$action = 'revision/finalise';
			}
			$title = 'View '.$type;

			$html = view('_main.transaction.form', compact('var','acckey', 'action', 'title'))->render();
			return $this->callForm($html);
		}

		private function transactionStore($data){
			$storeData = $this->convert_to_akv($data['input']['data']['storeData']);
			$max_revision = [];
			$value_revision = [];
			foreach ($storeData as $key => $value) {
				$keyCheck = explode('.',$key);
				if ($keyCheck[0] == 'max_revision') { $max_revision[$keyCheck[1]] = $value; }
				if ($keyCheck[0] == 'value_revision') { 
					$value_revision[$keyCheck[1]][$keyCheck[2]] = $value; 
				}
			}
			foreach ($value_revision as $key => $value) {
				$countVal = 0;
				foreach ($value as $keySc => $valueSc) {
					$countVal += $valueSc;
				}
				if ($countVal > $max_revision[$key]) {
					return [
						"responseType" => "notif",
						"info" => "Jumlah nilai revisi pada criteria : ".$key." melebihi jumlah soal yang ada. Jumlah soal yang ada : ".$max_revision[$key]." jumlah revisi ".$countVal
					];
				}else if($countVal < $max_revision[$key]){
					return [
						"responseType" => "notif",
						"info" => "Jumlah nilai revisi pada criteria : ".$key." kurang dari jumlah soal yang ada. Jumlah soal yang ada : ".$max_revision[$key]." jumlah revisi ".$countVal
					];
				}
			}
			if (empty($storeData['note'])) {
				return [
					"responseType" => "notif",
					"info" => "Harap isi note terlebih dahulu!"
				];
			}
			$store = Transaction::find($storeData['id']);
			if ($store->status != 'Pending') {
				return [
					"responseType" => "notif",
					"info" => "Tidak bisa merubah data ini! Pastikan data ini berstatus Pending"
				];
			}
			$newStoreResult = json_decode($store->result,true);
			foreach ($newStoreResult as $key => $item) {
				$highestCompetencies = 0;
				foreach ($item['resault'] as $keySc => $res) {
					$criteriaSlug = Str::slug($newStoreResult[$key]['criteria']['criteria'],'_');
					$competenciesSlug = Str::slug($newStoreResult[$key]['resault'][$keySc]['competencies_name'],'_');
					$max_question = $max_revision[$criteriaSlug];
					$new_revision_resault = $value_revision[$criteriaSlug][$competenciesSlug];
					if ($highestCompetencies < $new_revision_resault) { 
						$highestCompetencies = $new_revision_resault;
						$newStoreResult[$key]['criteria']['highest_competencies'] = $newStoreResult[$key]['resault'][$keySc]['competencies_name']; 
					}
					$newPercent = ($newStoreResult[$key]['resault'][$keySc]['real_resault']/$max_question)*100;
					$newStoreResult[$key]['resault'][$keySc]['real_percen'] = $newPercent;
					$newStoreResult[$key]['resault'][$keySc]['revision_resault'] = $new_revision_resault;
					$newPercent = ($new_revision_resault/$max_question)*100;
					$newStoreResult[$key]['resault'][$keySc]['revision_percen'] = $newPercent;
				}
			}
			$store->result = json_encode($newStoreResult);
			$store->status = Str::title($storeData['rf']);
			$store->note = $storeData['note'];
			$store->save();
			return [
				"Success" => true,
				"responseType" => "storeFormData",
				"info" => "Success!"
			];
		}

		private function transactionReport($data)
		{
			$Transaction = Transaction::with('getUser.getUserDetils')->find($data['input']['id']);
			if ($Transaction->status != 'Finalise') {
				return [
					"responseType" => "notif",
					"info" => "Data ini belum final"
				];
			}
			$Transaction->result = json_decode($Transaction->result);
			$view = view('_main.transaction.report', compact('Transaction'))->render();
			$nameFile = Str::slug($Transaction->name,'_').Carbon::now()->format('Ymd');
			$encodeImg = base64_encode(file_get_contents(url("images/Profilling_Logo.jpg")));
			
			$header1 = [ 'image'=>'data:image/jpeg;base64,'.$encodeImg, 'fit'=> [250, 250], 'alignment'=> 'center', 'margin' => [0, 20] ];
			$header2 = [
				'table' => [
					'widths' => ['auto', '*', 'auto', '*'],
					'body' => [
						[
							'Name', $Transaction->getUser->name, 
							'Perusahaan', $Transaction->getUser->getUserDetils->current_companies
						],
						[
							'Email', $Transaction->getUser->email,
							'Group/Jabatan', $Transaction->getUser->getUserDetils->work_title
						],
						[
							'Tgl Lahir', $Transaction->getUser->getUserDetils->date_of_birth,
							'Tgl Asessment', (new Carbon($Transaction->created_at))->format('d-M-Y')
						]
					]
				], 
				'margin' => [0, 20]
			];

			$pdfConfig = [];
			$pdfConfig[] = $header1;
			$pdfConfig[] = $header2;
			$result = [];
			$result[] = [ ['alignment'=> 'center', 'text' => 'Criteria'], ['alignment'=> 'center', 'text' => 'Competencies']];
			foreach ($Transaction->result as $idx => $data) { $result[] = [ $data->criteria->criteria, $data->criteria->highest_competencies ]; }
			$pdfConfig[] = ['text' => 'Profilling Resault', 'style' => 'header', 'alignment'=> 'center',  'margin' => [0, 20]];
			$pdfConfig[] = [
				'table' => [
					'widths' => ['*', '*'],
					'body' => $result
				],
				'pageBreak' =>  'after'
			];
			
			foreach ($Transaction->result as $idx => $data) {
				$criteria = Criteria::find($data->criteria->id);
				$pdfConfig[] = ['text' => $criteria->criteria, 'style' => 'header', 'alignment'=> 'center',  'margin' => [0, 20]];
				$pdfConfig[] = ['text' => $criteria->description,  'margin' => [0, 20]];
				if ($criteria->flag == 1) {
					$cmptcsDescr_0 = Competencies::find($data->resault[0]->competencies_id)->description;
					$cmptcsDescr_1 = Competencies::find($data->resault[1]->competencies_id)->description;
					$cmptcsDescr_2 = Competencies::find($data->resault[2]->competencies_id)->description;
					$cmptcsDescr_3 = Competencies::find($data->resault[3]->competencies_id)->description;
					$addPage = [
						'table' => [
							'widths' => ['*','*'],
							'body' => [
								[
									[
										'text'=>$data->resault[0]->competencies_name, 
										'alignment'=> 'center', 
										'border'=> [true, true, true, false], 
										'fillColor'=> 'green'
									],
									[
										'text'=>$data->resault[1]->competencies_name, 
										'alignment'=> 'center', 
										'border'=> [true, true, true, false], 
										'fillColor'=> 'red'
									],
								],
								[
									[
										'text'=>$data->resault[0]->revision_percen.'%', 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'green'
									],
									[
										'text'=>$data->resault[1]->revision_percen.'%', 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'red'
									],
								],
								[
									[
										'text'=>$data->resault[0]->competencies_name == $data->criteria->highest_competencies ? 'Dominan' : '-', 
										'alignment'=> 'center', 
										'fillColor'=> 'green'
									],
									[
										'text'=>$data->resault[1]->competencies_name == $data->criteria->highest_competencies ? 'Dominan' : '-', 
										'alignment'=> 'center', 
										'fillColor'=> 'red'
									],
								],
								[
									[
										'text'=>$cmptcsDescr_0, 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'green'
									],
									[
										'text'=>$cmptcsDescr_1, 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'red'
									],
								],
								[
									[
										'text'=>$data->resault[2]->competencies_name, 
										'alignment'=> 'center', 
										'border'=> [true, true, true, false], 
										'fillColor'=> 'yellow'
									],
									[
										'text'=>$data->resault[3]->competencies_name, 
										'alignment'=> 'center', 
										'border'=> [true, true, true, false], 
										'fillColor'=> 'blue'
									],
								],
								[
									[
										'text'=>$data->resault[2]->revision_percen.'%', 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'yellow'
									],
									[
										'text'=>$data->resault[3]->revision_percen.'%', 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'blue'
									],
								],
								[
									[
										'text'=>$data->resault[2]->competencies_name == $data->criteria->highest_competencies ? 'Dominan' : '-', 
										'alignment'=> 'center', 
										'fillColor'=> 'yellow'
									],
									[
										'text'=>$data->resault[3]->competencies_name == $data->criteria->highest_competencies ? 'Dominan' : '-', 
										'alignment'=> 'center', 
										'fillColor'=> 'blue'
									],
								],
								[
									[
										'text'=>$cmptcsDescr_2, 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'yellow'
									],
									[
										'text'=>$cmptcsDescr_3, 
										'alignment'=> 'center', 
										'border'=> [true, false, true, true], 
										'fillColor'=> 'blue'
									],
								]
							]
						]
					];
					$addPage['pageBreak'] = 'after';
					$pdfConfig[] = $addPage;
				}
				if ($criteria->flag == 2){
					$widths = [];
					$row1 = [];
					$row2 = [];
					$row3 = [];
					$row4 = [];
					foreach ($data->resault as $idx => $resDt) {
						$dominan = $resDt->competencies_name == $data->criteria->highest_competencies ? 'Dominan' : '-';
						$color = $resDt->competencies_name == $data->criteria->highest_competencies ? 'red' : 'blue';
						$cmptcDescr = Competencies::find($resDt->competencies_id)->description;
						$widths[] = '*';
						$row1[] = [
							'text'=>$resDt->competencies_name, 
							'alignment'=> 'center', 
							'fillColor'=> $color
						];
						$row2[] = [
							'text'=>$resDt->revision_percen.'%', 
							'alignment'=> 'center', 
							'fillColor'=> $color
						];
						$row3[] = [
							'text'=>$dominan, 
							'alignment'=> 'center', 
							'fillColor'=> $color
						];
						$row4[] = [
							'text'=>$cmptcDescr, 
							'alignment'=> 'center', 
							'fillColor'=> $color
						];
					}
					$addPage = [
						'table' => [
							'widths' => $widths,
							'body' => [$row1, $row2, $row3, $row4]
						]
					];
					$addPage['pageBreak'] = 'after';
					$pdfConfig[] = $addPage;
				}
			}
			return [
				"Success" => true,
				"responseType" => "generateReport",
				"generateExcel" => [
					"name" => $nameFile,
					"view" => base64_encode($view)
				],
				"generatePDF" => [
					"name" => $nameFile,
					"render" => $pdfConfig
				]
			];
		}
	// transaction
}
