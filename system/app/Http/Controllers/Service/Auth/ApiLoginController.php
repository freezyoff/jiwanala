<?php 

namespace App\Http\Controllers\Service\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ApiLoginController{
	
	public function login(\Illuminate\Http\Request $req){
		if(\Auth::attempt(['name' => request('name'), 'password' => request('password')])){ 
			$success['code'] = 200;
            $success['token'] =  \Auth::user()->createApiToken(now()->format('Y-m-d H:i:s'));
            return response()->json(['success'=>$success], 200);
        } 
        else{ 
			$error['code'] = 403;
			$error['msg'] = trans('service/auth/login.error.login');
            return response()->json(['error'=>$error], 403); 
        } 
	}
	
	public function logout(\Illuminate\Http\Request $request){
		$user = \App\Libraries\Service\Auth\User::where(
			'api_token',
			'=', 
			$request->header('Authorization')
		)->first();
		
		if ($request->header('Accept') != 'application/json' || 
			!$request->header('Authorization') || 
			!$user) {
			$error['code']=401;
			$error['msg']=trans('http_error.401');
			return response()->json($error, 401); 
		}
		
		$user->destroyApiToken();
		$success['code']= 200;
		return response()->json(['success'=>$success], 200);
	}
	
	public function relogin(\Illuminate\Http\Request $request){
		//checking token if associate with user
		$user = \App\Libraries\Service\Auth\User::where(
			'api_token',
			'=',
			$request->header('Authorization')
			)->first();
			
		//check the header credentials
		if ($request->header('Accept') != 'application/json' || 
			!$request->header('Authorization') || 
			!$user) {
			$error['code'] = 403;
			$error['msg'] = trans('service/auth/login.error.token_expired');
			return response()->json(['error'=>$error], 403); 
		}
		
		$success['code'] = 200;
		return response()->json(['success'=>$success], 200);
	}
}