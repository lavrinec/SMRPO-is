<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


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

   protected $maxAttempts = 3;
   protected $decayMinutes = 2;
   /**
    * Create a new controller instance.
    *
    * @return void
    */

     public function login(Request $request)
     {

       if ($this->hasTooManyLoginAttempts($request)) {
         return $this->sendLockoutResponse($request);
       }
       $this->incrementLoginAttempts($request);



         if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

              return view('/tables/simple');

         }else return $this->sendFailedLoginResponse($request);
     }
}
