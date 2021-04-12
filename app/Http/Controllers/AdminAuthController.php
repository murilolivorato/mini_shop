<?php

namespace App\Http\Controllers;


use Validator;



use Illuminate\Contracts\Auth\Guard;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Requests\LoginRequest;


use Auth;
use App\Models\UserAdmin;

use App\Classes\Auth\VerifyUserPassword;


class AdminAuthController extends Controller
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



    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $auth;

    /**
     * Create a new controller instance.
     *confi
     * @return void
     */

    /*---------------------------------------------------------------------------------
--------------------------------------------------------------------------- POST LOGIN */
    public function postLogin(LoginRequest $request){
        return VerifyUserPassword::process($request , 'user_admin');
    }

    /*--------------------------------------------------------------------------  USER INFO */
    public function info(Request $request){

        $user = auth('user_admin')->user();

        $user_admin = UserAdmin::find($user->id);
        if($user_admin->AdminInfo){
            return response()->json([
                'email'         => $user->email ,
                'name'          => $user_admin->AdminInfo->name ,
                'last_name'     => $user_admin->AdminInfo->last_name ,
                'image_profile' => $user_admin->ImageProfile()->exists() ? $user_admin->ImageProfile->ImagePathUrl : null
            ]);
        }
    }

    /*--------------------------------------------------------------------------  REGISTER */
    public function register(Request $request){

    }

    public function getLogout(){
    if(auth('user_admin')->user()) {
        auth('user_admin')->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
    }

        return response()->json('Logged out successfully', 200);

    }










}
