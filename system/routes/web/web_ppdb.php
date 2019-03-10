<?php
Route::get('', function(){
	return view('ppdb.landing');
});

Route::name('register')
	->group(function(){
	Route::get('register', '\App\Http\Controllers\PPDBController@showRegister');
	Route::post('register', '\App\Http\Controllers\PPDBController@register');
});