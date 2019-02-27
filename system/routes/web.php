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
$domain .= App::environment('production')? '.org' : '.local';
$locale = App::getLocale();

Route::domain('service.'.$domain)
	->prefix($locale)
	->name('service.')
	->group(base_path('routes/web/web_service.php'));

Route::domain('my.'.$domain)
	->prefix($locale)
	->name('my.')
	->middleware(['auth', 'timezone'])
	->group(base_path('routes/web/web_my.php'));