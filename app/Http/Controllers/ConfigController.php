<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\ConfigRepositoryInterface;
use Auth;
class ConfigController extends Controller{
	protected $repo;
    public function __construct(ConfigRepositoryInterface $ConfigRepository){
        $this->repo = $ConfigRepository;
    }

    public function menu(request $request){
        $res = $this->repo->menu(Auth::guard('user')->user()->roll_id);
        return response()->json($res);
    }

    public function index(request $request){
        $res = $this->repo->index($request->all());
        return response()->json($res);
    }

    public function tabList(request $request){
        $res = $this->repo->tabList($request->all());
        return $res;
    }
}
