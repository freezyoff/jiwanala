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
$routeFilePath = false;
if (App::environment('production')){
	//modify to your remote domain setting
	$domain .= '.org';
	//modify to your remote route file path
	$routeFilePath = config('server.paths.routes');
}
else{
	//modify to your local domain setting
	$domain .= '.local';
	//modify to your remote route file path
	$routeFilePath = '../system/routes/';
}

Route::get('/test', function(){
	$hh = Hash::make(now()->format('Y-m-d H:i:s'));
	return json_encode([
		'hash'=>$hh,
		'length'=>strlen($hh)
	]);
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