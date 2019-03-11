<?php

namespace App\Http\Controllers;

//use Adldap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Services\Auth\LimitLoginService;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    private $limitLoginSrv;

    /**
     * Object that define how users are authenticated for each request.
     *
     * @var object
     */
    protected $guard;

     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LimitLoginService $limitLoginSrv)
    {
        $this->guard = Auth::guard();
        $this->limitLoginSrv = $limitLoginSrv;
    }

    public function index()
    {
        /*$results = Adldap::search()->where('cn', '=', 'darrenting')->get();
        echo '<pre>';
        print_r($results);
        echo '</pre>';*/
        return view('welcome');
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended($this->redirectPath());
        }

        return view('themes/default/login', [
            'username' => $this->username(),
            'password' => $this->password()
        ]);
    }

    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required | string',
            $this->password() => 'required | string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        return ( $this->limitLoginSrv->ifActiveLoginUser($credentials[$this->username()], true) )
            ? $this->guard->attempt($credentials):false;
    }

    public function username()
    {
        return 'login';
    }

    private function password()
    {
        return 'password';
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), $this->password());
    }

    /**
     * 定義登入後跳轉位置
     *
     * @return string
     */
    protected function redirectTo()
    {
        return '/';
    }

    protected function guard()
    {
        return $this->guard;
    }
}
