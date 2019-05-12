<?php

Route::get('/', function(){ 
	return view('my.system.landing'); 
})->name('landing');

Route::prefix('user')
		->name('user.')
		->group(function(){
			
	Route::name('index')
		->middleware(['permission:system.user.list'])
		->any('', '\App\Http\Controllers\My\System\UserController@index');
	Route::name('create')
		->middleware(['permission:system.user.post'])
		->any('create/{nip}/{email}', '\App\Http\Controllers\My\System\UserController@create');
	Route::name('delete')
		->middleware(['permission:system.user.delete'])
		->any('delete/{id}', '\App\Http\Controllers\My\System\UserController@destroy');
	Route::name('resetPwd')
		->middleware(['permission:system.user.patch'])
		->any('reset/{id}', '\App\Http\Controllers\My\System\UserController@reset');
});

/*
Route::prefix('division')
	->name('division.')
	->group(function(){
	
	Route::name('landing')
		->get('', '\App\Http\Contollers\My\System\DivisionController@index');
	
});

*/