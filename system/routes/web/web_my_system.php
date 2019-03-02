<?php

Route::get('/', function(){ 
	return view('my.system.landing'); 
})->name('landing');

Route::prefix('user')
		->name('user.')
		->group(function(){
			
	Route::name('index')
		->any('', '\App\Http\Controllers\My\System\UserController@index');
			
});