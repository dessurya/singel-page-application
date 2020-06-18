<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRegistryRepositoryInterface;

use Hash;
use App\Model\User;
class AccountController extends Controller{

	protected $repo;
    public function __construct(UserRegistryRepositoryInterface $UserRegistry){
        $this->repo = $UserRegistry;
    }

	public function self(){
        return view('_main.account.self');
    }

    public function getForm(request $request){
    	$data = $this->repo->findById(base64_decode($request->id));
    	return response()->json([
    		'html' => [
    			'excute' => true,
    			'location' => 'body .container.body .main_container .right_col .x_content',
    			'value' => view('_main.account.form', compact('data'))->render()
    		]
    	]);
    }
}
