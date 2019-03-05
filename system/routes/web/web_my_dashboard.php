<?php

Route::name('landing')
	->group(function(){
	Route::get('/','\App\Http\Controllers\My\DashboardController@index');
	Route::post('/','\App\Http\Controllers\My\DashboardController@index');
});