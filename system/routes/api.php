<?php

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
$domain .= \App::environment('production')? '.org' : '.local';
$filePath = 'routes/api';

/*
|--------------------------------------------------------------------------
|	Untuk client yang mengenali Nama Domain Server 
|--------------------------------------------------------------------------
|
*/
Route::domain('service.'.$domain)
	->name('api.service.')
	->group(base_path($filePath.'/api_service.php'));

Route::domain('my.'.$domain)
	->name('api.my.')
	->middleware('auth.api')
	->group(base_path($filePath.'/api_my.php'));

/*
|--------------------------------------------------------------------------
| 	Untuk client yang tidak bisa mengenali Nama Domain Server
|--------------------------------------------------------------------------
|
*/
if (!App::environment('production')){
	Route::domain(\Request::server('SERVER_ADDR'))->group(function() use($filePath){
		Route::name('api.service.')
			->group(base_path($filePath.'/api_service.php'));

		Route::name('api.my.')
			->middleware('auth.api')
			->group(base_path($filePath.'/api_my.php'));
	});	
}