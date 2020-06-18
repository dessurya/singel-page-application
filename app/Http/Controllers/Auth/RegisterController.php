<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRegistryRepositoryInterface;

use App\Model\Master;

class RegisterController extends Controller
{

    protected $repo;
    public function __construct(UserRegistryRepositoryInterface $UserRegistry){
        $this->repo = $UserRegistry;
    }

    public function view(){
        $master = [];
        $master['industry'] = Master::where('status', 'Y')->where('type', 'industry')->get();
        $master['level'] = Master::where('status', 'Y')->where('type', 'level')->get();
        $master['marital'] = Master::where('status', 'Y')->where('type', 'marital')->get();
        $master['education'] = Master::where('status', 'Y')->where('type', 'education')->get();
        $master['religion'] = Master::where('status', 'Y')->where('type', 'religion')->get();
        $master['competencies'] = Master::where('status', 'Y')->where('type', 'competencies')->get();
        return view('signup', compact('master'));
    }

    public function create(request $request){
        $res = $this->repo->signup($request->all());
        return response()->json($res);
    }
}
