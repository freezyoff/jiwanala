<?php

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
if (!App::environment('production')) {
	ini_set('max_execution_time', 0);
}
$domain = App::environment('production')? config('jiwanala.domain.production') : config('jiwanala.domain.local');
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
	->middleware(['auth:my', 'timezone'])
	->group(function() use($locale){
		
		Route::get('', function() use($locale){
			return redirect($locale);
		});
		
		Route::get($locale, function(){
			return redirect()->route('my.dashboard.landing');
		});
	
		Route::prefix($locale)->group(base_path('routes/web/web_my.php'));
			
	}
);

Route::domain('ppdb.'.$domain)
	->name('ppdb.')
	->middleware(['timezone'])
	->group(function() use($locale){
		Route::get('', function() use($locale){
			return redirect($locale);
		});
		Route::prefix($locale)->group(base_path('routes/web/web_ppdb.php'));
	}
);