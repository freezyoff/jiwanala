<?php 

//domain service.jiwa-nala.org

//echo resource_path().'/views/layouts/'.$theme;exit;

Route::get('/', function () {
	return redirect()->route('service.auth.login');
});

Route::name('service.client.timezone')->post('/put/timezone', function(){
	Request::session()->put('timezone', Request::input('timezone'));
	//return '<pre>'.print_r(session(),true).'</pre>';
	return redirect(Request::input('redirect'));
});
	
Route::prefix('auth')
	->middleware(['timezone'])
	->group(function () {
	
	Route::name('service.auth.login')->group(function(){
		Route::get('login', '\App\Http\Controllers\Service\Auth\LoginController@showLoginForm');
		Route::post('login', '\App\Http\Controllers\Service\Auth\LoginController@login');		
	});
	
	Route::name('service.auth.logout')->group(function(){
		Route::any('logout', '\App\Http\Controllers\Service\Auth\LoginController@logout');
	});
	
	Route::name('service.auth.forgot')->group(function(){
		Route::get('forgot', '\App\Http\Controllers\Service\Auth\ForgotPasswordController@showLinkRequestForm');
		Route::post('forgot', '\App\Http\Controllers\Service\Auth\ForgotPasswordController@sendResetLinkEmail');
	});
	
	Route::name('service.auth.reset')->group(function(){
		Route::get('resetpwd/{token}', '\App\Http\Controllers\Service\Auth\ResetPasswordController@showResetForm');
		Route::post('resetpwd/{token}', '\App\Http\Controllers\Service\Auth\ResetPasswordController@reset');
	});
});