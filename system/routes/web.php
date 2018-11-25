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
if (App::environment('production')){
	//modify to your remote domain setting
	$domain .= '.org';
}
else{
	//modify to your local domain setting
	$domain .= '.local';
}

Route::domain('service.'.$domain)->group(function(){
	if (App::environment('production')){
		//modify to your remote domain setting
		require_once "../GIT-JIWANALA/system/routes/web_service.php";
	}
	else{
		//modify to your local domain setting
		require_once "../system/routes/web_service.php";
	}
});

Route::domain('my.'.$domain)
	->middleware('auth')
	->name('my.')
	->group(function () {
		
	if (App::environment('production')){
		//modify to your remote domain setting
		require_once "../GIT-JIWANALA/system/routes/web_my.php";
	}
	else{
		//modify to your local domain setting
		require_once "../system/routes/web_my.php";
	}	
});