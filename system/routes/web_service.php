<?php 
//domain: SERVICE

Route::get('/', function () {
	return redirect()->route('service.auth.login');
});

Route::name('client.timezone')->post('/put/timezone', function(){
	Request::session()->put('timezone', Request::input('timezone'));
	return redirect(Request::input('redirect'));
});
	
Route::prefix('auth')
	->name('auth.')
	->middleware(['timezone'])
	->group(function () {
	
	Route::name('login')->group(function(){
		Route::get('login', '\App\Http\Controllers\Service\Auth\LoginController@showLoginForm');
		Route::post('login', '\App\Http\Controllers\Service\Auth\LoginController@login');		
	});
	
	Route::name('logout')->group(function(){
		Route::any('logout', '\App\Http\Controllers\Service\Auth\LoginController@logout');
	});
	
	Route::name('forgot')->group(function(){
		Route::get('forgot', '\App\Http\Controllers\Service\Auth\ForgotPasswordController@showLinkRequestForm');
		Route::post('forgot', '\App\Http\Controllers\Service\Auth\ForgotPasswordController@sendResetLinkEmail');
	});
	
	Route::name('reset')->group(function(){
		Route::get('resetpwd/{token}', '\App\Http\Controllers\Service\Auth\ResetPasswordController@showResetForm');
		Route::post('resetpwd/{token}', '\App\Http\Controllers\Service\Auth\ResetPasswordController@reset');
	});
});