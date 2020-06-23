<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
        if ($request->reset == 'true') {
            $remember_token = Str::random(32);
            $user = User::where('email',$request->email)->first();
            $user->remember_token = $remember_token;
            $user->password = null;
            $user->save();
            return redirect()->route('auth.login.view')->with('status', 'Your account password is reset please check your email...')->withInput();
        }else if ($request->reset == 'false'){
            return $this->loginEP([
                'email' => $request->email,
                'password' => $request->password
            ]);
        }
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
        if (empty($user)) {
            return redirect()->route('auth.login.view')->with('status', 'Your link is out of date or has been used before')->withInput();
        }
        Auth::guard('user')->loginUsingId($user->id);
        $user = User::find(Auth::guard('user')->user()->id);
        $user->remember_token = null;
        $user->save();
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