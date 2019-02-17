<?php

Route::name('dashboard')
	->group(function(){
	
	Route::get('/', function () {
		return view('my.landing');
	});
	
});

Route::prefix('misc')
	->name('misc.')
	->group(base_path('routes/web/web_my_misc.php'));

Route::prefix('service')
	->name('service.')
	->middleware(['permission.context:service'])
	->group(base_path('routes/web/web_my_service.php'));

Route::prefix ('bauk')
	->name('bauk.')
	->middleware(['permission.context:bauk'])
	->group(base_path('routes/web/web_my_bauk.php'));