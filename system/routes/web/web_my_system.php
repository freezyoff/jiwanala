<?php

Route::get('/', function(){ 
	return view('my.system.landing'); 
})->name('landing');

Route::prefix('user')
		->name('user.')
		->group(function(){
			
	Route::name('index')
		->any('', '\App\Http\Controllers\My\System\UserController@index');
	Route::name('create')
		->any('create/{nip}/{email}', '\App\Http\Controllers\My\System\UserController@create');
	Route::name('delete')
		->any('delete/{id}', '\App\Http\Controllers\My\System\UserController@destroy');
	Route::name('resetPwd')
		->any('reset/{id}', '\App\Http\Controllers\My\System\UserController@reset');
});