<?php

Route::name('dashboard')
	->group(function(){
	
	Route::get('/', function () {
		return view('my.landing');
	});
	
});

Route::prefix('service')
	->name('service.')
	->middleware(['permission.context:service'])
	->group(function(){
	
	//service for administer user and job
	//@TODO create service
	
	Route::get('/', function(){ 
		return view('my.service.landing'); 
	})->name('landing');
	
});

Route::prefix ('bauk')
	->name('bauk.')
	->middleware(['permission.context:bauk'])
	->group(base_path('routes/web_my_bauk.php'));