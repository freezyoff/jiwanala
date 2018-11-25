<?php

/*
\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    echo'<pre>';
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
    echo'</pre>';
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$domain = 'jiwa-nala';
if (App::environment('local')){
	$domain .= '.local';
}
else{
	$domain .= '.org';
}

Route::domain($domain)->group(function(){
	Route::name('web')->get('/web', function () { 
			return view('web.landing'); 
		})->name('web');
});

Route::domain('service.'.$domain)->group(function(){
	if (App::environment('local')){
		require_once "../system/routes/web_service.php";
	}
	else{
		throw new Exception('TODO: path Route file for service.jiwa-nala.org');
	}
});

Route::domain('tutor.'.$domain)->group(function(){
	if (App::environment('local')){
		require_once "../system/routes/web_tutor.php";
	}
	else{
		throw new Exception('TODO: path Route file for tutor.jiwa-nala.org');
	}
});

Route::domain('my.'.$domain)
	->middleware('auth')
	->name('my')
	->group(function () {
		
	if (App::environment('local')){
		require_once "../system/routes/web_my.php";
	}
	else{
		throw new Exception('TODO: path Route file for my.jiwa-nala.org');
	}
	
});