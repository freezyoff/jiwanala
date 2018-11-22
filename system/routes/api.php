<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
|	Route::middleware('auth:api')->get('/user', function (Request $request) {
|		return $request->user();
|	});
|
*/

$domain = 'jiwa-nala';
if (App::environment('local')){
	$domain .= '.local';
}
else{
	$domain .= '.org';
}

$appversion = str_replace('.','',config('app.version'));

Route::domain('bimbel.'.$domain)->group(function () {
	Route::post('signin', function( Request $req ){
		$username = $req->input('username', false);
		$password = $req->input('password', false);
		
		$student = \App\DBModels\JNBimbel\Student::where('username','=',$username)->first();
		if (!$student) return response()->json(['signin'=>false]);
		return response()->json( $student->signin($username, $password) );
	});
});

Route::domain('my.'.$domain)->group(function () {
	Route::get('/', function(){
		return 'my.jiwa-nala.local|org/api/';
	});
});

/*
|--------------------------------------------------------------------------
| LOCAL DEVELOPMENT ONLY - Remove on deployment
|--------------------------------------------------------------------------
|
*/
//192.168.0.4
Route::domain('192.168.0.4')->group(function(){
	Route::post('signin', function( Request $req ){
		$username = $req->input('username', false);
		$password = $req->input('password', false);
		
		$student = \App\DBModels\JNBimbel\Student::where('username','=',$username)->first();
		if (!$student) return response()->json(['signin'=>false]);
		return response()->json( $student->signin($username, $password) );
	});
});