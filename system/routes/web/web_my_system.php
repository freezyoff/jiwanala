<?php

Route::get('/', function(){ 
	return view('my.system.landing'); 
})->name('landing');

Route::resource('user', '\App\Http\Controllers\My\System\UserController');