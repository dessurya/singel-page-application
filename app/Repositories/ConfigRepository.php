<?php

namespace App\Repositories;

use App\Repositories\Interfaces\ConfigRepositoryInterface;

use App\Model\Role;
use App\Model\Config;
use App\Model\User;
use App\Model\UserDetils;
use App\Model\Master;
use App\Model\Question;

use Auth;
use DataTables;

class ConfigRepository implements ConfigRepositoryInterface{

	public function menu($roll){
		$role = Role::find($roll);
		$accs = json_decode($role->access_menu, true);
		$menu = $accs['menu'];
		return [
			"responseType" => "setMenuOnSeasion",
			"accKey" => base64_encode(json_encode($accs['accKey'])),
			"menuOnSeasion" => base64_encode(view('_layout.content.menu', compact('menu'))->render())
		];
	}

	public function index($request){
		if ($request['select'] == 'change_password') {
			return $this->change_password();
		}else if ($request['select'] == 'selfUpdate') {
			return $this->selfUpdate();
		}else if ($request['select'] == 'takeProfilling') {
			return $this->takeProfilling();
		}
		$access = json_decode(base64_decode($request['access']),true);
		if (array_key_exists($request['select'],$access)) {
			$access = $access[$request['select']];
			$access['key'] = $request['select'];
		}else{
			return [
				'Success' => false,
				'note' => 'Access denied'
			];
		}
		$access['config'] = $this->getConfig($access['key']);
		$access['content'] = base64_encode(view('_layout.content.content', compact('access'))->render());
		$access['responseType'] = 'bodyAccess';
		$access['config'] = base64_encode(json_encode($access['config']));
		return $access;
	}

	public function getConfig($acc){
		$config = Config::where('accKey',$acc)->first();
		return json_decode($config->config, true);
		return $config;
	}

	public function tabList($req){
		$Model = "App\Model\\".$req['dataUrl'];
		if ($req['dataUrl'] == 'Vtransaction' and Auth::guard('user')->user()->roll_id == 2) {
			$data = $Model::where('user_id',Auth::guard('user')->user()->id)->get();
		}else{
			$data = $Model::get();
		}
		return Datatables::of($data)->escapeColumns(['*'])->make(true);
    }

    public function change_password(){
    	$html = view('change_password')->render();
    	return [
    		"responseType" => "change_password",
    		"callForm" => base64_encode($html)
    	];
    }

    public function selfUpdate(){
    	$var = [];
    	$var['User'] = User::find(Auth::guard('user')->user()->id);
    	$var['Detils'] = UserDetils::where('user_id',Auth::guard('user')->user()->id)->first();
    	$var['Education'] = Master::where([ 'type' => 'education', 'status' => 'Y' ])->get();
    	$var['Industry'] = Master::where([ 'type' => 'Industry', 'status' => 'Y' ])->get();
    	$var['Level'] = Master::where([ 'type' => 'level', 'status' => 'Y' ])->get();
    	$var['Marital'] = Master::where([ 'type' => 'marital', 'status' => 'Y' ])->get();
    	$var['Religion'] = Master::where([ 'type' => 'religion', 'status' => 'Y' ])->get();
    	$var['Competencies'] = Master::where([ 'type' => 'competencies', 'status' => 'Y' ])->get();
    	$title = 'Self Update';
    	$action = 'edit';
    	$acckey = 'selfUpdate';
    	$html = view('_main.uarUser.form', compact('var','acckey', 'action', 'title'))->render();
    	return [
    		"responseType" => "selfUpdate",
    		"callForm" => base64_encode($html)
    	];
    }

    public function takeProfilling(){
    	$question = Question::where('status', 'Y')->orderBy('sort', 'asc')->orderBy('criteria', 'asc')->orderBy('question', 'asc')->get();
    	$questionRender = [];
    	$build = null;
    	foreach ($question as $key => $val) {
    		$build .= view('_main.takeProfilling.question', compact('key', 'val'))->render();
    		if (($key+1)%4 == 0) {
    			$questionRender[] = base64_encode($build);
    			$build = null;
    		}
    	}
    	$countPage = ceil(count($question)/4);
    	$html = view('_main.takeProfilling.form', compact('countPage'))->render();
    	return [
    		"responseType" => "takeProfilling",
    		"question" => $questionRender,
    		"callForm" => base64_encode($html)
    	];
    }
}