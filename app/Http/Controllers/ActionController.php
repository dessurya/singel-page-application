<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ActionRepositoryInterface;

class ActionController extends Controller{

	protected $repo;
    public function __construct(ActionRepositoryInterface $ActionRepository){
        $this->repo = $ActionRepository;
    }

    public function action(request $request){
    	$data = $this->repo->action($request->all());
    	return response()->json($data);
    }
}
