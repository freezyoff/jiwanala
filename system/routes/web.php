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
$routeFilePath = false;
if (App::environment('production')){
	//modify to your remote domain setting
	$domain .= '.org';
	//modify to your remote route file path
	$routeFilePath = '../GIT-JIWANALA/system/routes';
}
else{
	//modify to your local domain setting
	$domain .= '.local';
	//modify to your remote route file path
	$routeFilePath = '../system/routes';
}

Route::domain('service.'.$domain)->group(function() use ($routeFilePath){
	require_once $routeFilePath."/web_service.php";
});

Route::domain('my.'.$domain)
	->name('my.')
	->middleware('auth')
	->group(function () use($routeFilePath){
		
	require_once $routeFilePath."/web_my.php";
});