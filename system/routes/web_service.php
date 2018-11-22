<?php 

//domain service.jiwa-nala.org

//echo resource_path().'/views/layouts/'.$theme;exit;

Route::get('/', function () {
	return redirect()->route('service.auth.login');
});
	
Route::prefix('auth')->group(function () {
	
	Route::name('service.auth.login')->group(function(){
		Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm');
		Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');		
	});
	
	Route::name('service.auth.logout')->group(function(){
		Route::any('logout', '\App\Http\Controllers\Auth\LoginController@logout');
	});
});

Route::prefix('plugins')
	->middleware(['auth'])
	->group(function(){
	Route::name('service.plugins.list')
		->get('list', function(){
			return "service.plugins.list";
		});
});