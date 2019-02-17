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
$domain .= App::environment('production')? '.org' : '.local';

Route::domain('service.'.$domain)
	->name('api.service.')
	->group(base_path('routes/api/api_service.php'));

Route::domain('my.'.$domain)
	->name('api.my.')
	->middleware('auth.api')
	->group(base_path('routes/api/api_my.php'));

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