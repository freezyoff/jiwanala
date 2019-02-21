<?php 

Route::name('auth.')
	->group(function(){
	Route::name('login')
		->any('login', '\App\Http\Controllers\Service\Auth\ApiLoginController@login');
	
	Route::name('relogin')
		->any('relogin', '\App\Http\Controllers\Service\Auth\ApiLoginController@relogin');
		
	Route::name('logout')->any('logout', '\App\Http\Controllers\Service\Auth\ApiLoginController@logout');
});