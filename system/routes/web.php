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
ini_set('max_execution_time', 300);
$domain = 'jiwa-nala';
$domain .= App::environment('production')? '.org' : '.local';
$locale = Session::get('locale', App::getLocale());

Route::domain('service.'.$domain)
	->name('service.')
	->group(function() use($locale){
		
		Route::get('', function() use($locale){
			return redirect($locale);
		});
	
		Route::prefix($locale)->group(base_path('routes/web/web_service.php'));	
			
	}
);

Route::domain('my.'.$domain)
	->name('my.')
	->middleware(['auth', 'timezone'])
	->group(function() use($locale){
		
		Route::get('', function() use($locale){
			return redirect($locale);
		});
	
		Route::prefix($locale)->group(base_path('routes/web/web_my.php'));
			
	}
);