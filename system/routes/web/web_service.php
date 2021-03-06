<?php 
//domain: SERVICE

Route::get('/', function () {
	return redirect()->route('service.auth.login');
});

Route::name('client.timezone')->post('/put/timezone', function(){
	Request::session()->put('timezone', Request::input('timezone'));
	return redirect(Request::input('redirect'));
});
	
//domain my
Route::prefix('auth')
	->name('auth.')
	->middleware(['timezone'])
	->group(function () {
	
	Route::name('login')
		->middleware(['guest:my'])
		->group(function(){
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

//domain ppdb
Route::prefix('auth/ppdb')
	->name('auth.ppdb.')
	->middleware(['timezone'])
	->group(function(){
	
	Route::get('', '\App\Http\Controllers\Service\Auth\PPDBController@index');

	Route::name('signin')
		->middleware(['guest:ppdb'])
		->post('signin', '\App\Http\Controllers\Service\Auth\PPDBController@signIn');
		
	Route::name('signout')
		->any('signout', '\App\Http\Controllers\Service\Auth\PPDBController@signOut');
	
	Route::name('register')
		->post('register', '\App\Http\Controllers\Service\Auth\PPDBController@register');
});

Route::name('server.requirements')
	->get('server/requirements', function(){
	return response()->json([
		'Laravel'=>[
			'OpenSSL'=> 	extension_loaded('openssl'),
			'PDO'=> 		extension_loaded('pdo'),
			'Mbstring' =>	extension_loaded('mbstring'),
			'Tokenizer'=> 	extension_loaded('tokenizer'),
			'XML'=> 		extension_loaded('xml'),
			'Ctype'=> 		extension_loaded('ctype'),
			'JSON'=>		extension_loaded('json'),
			'BCMath'=>		extension_loaded('bcmath'),			
		],
		'Application'=>[
			'Fileinfo'=> 	extension_loaded('fileinfo'),
		],
	]);
});