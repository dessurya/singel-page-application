<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use App\Model\User;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function guard(){
        return Auth::guard();
    }

    public function view(){
        return view('login');
    }

    public function newUserLogin(request $request){
        $remember = $request->rememberMe;
        $loginAct = $this->loginId($remember);
        return redirect()->route('dashboard');
    }

    public function login(request $request){
        return $this->loginEP([
            'email' => $request->email,
            'password' => $request->password
        ]);
    }

    private function loginEP($value){
        $message = [];
        $validator = Validator::make($value, [
          'email' => 'required|email',
          'password' => 'required',
        ], $message);
        if($validator->fails()){
          return redirect()->route('auth.login.view')->withErrors($validator)->withInput();
        }
        if (Auth::guard('user')->attempt(['email' => $value['email'], 'password' => $value['password'], 'status' => 'Y' ])){
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->route('auth.login.view')->with('status', 'Your account is not active or wrong password')->withInput();
        }
    }

    private function loginId($code){
        $user = User::where('remember_token', $code)->first();
        Auth::guard('user')->loginUsingId($user->id);
        return [ 'Success' => true ];
    }

    public function logout(){
        $user = User::find(Auth::guard('user')->user()->id);
        if (empty($user->password)) {
            return [ 
                'responseType' => 'notif',
                'info' => 'Anda tidak dapat logout mohon buat password terlebih dahulu..!'
            ];
        }
        auth()->guard('user')->logout();
        return [ 
            'Success' => true,
            'responseType' => 'refresh',
            'info' => 'Success!'
        ];
    }
}