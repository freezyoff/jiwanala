<?php

Route::name('landing')
	->group(function(){
	Route::get('/','\App\Http\Controllers\My\Dashboard\DashboardController@index');
	Route::post('/','\App\Http\Controllers\My\Dashboard\DashboardController@index');
});

Route::name('division.landing')
	->prefix('division')
	->group(function(){
	Route::get('', '\App\Http\Controllers\My\Dashboard\DivisionController@index');
});