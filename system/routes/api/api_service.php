<?php 

Route::name('auth.')
	->group(function(){
	Route::name('login')
		->post('login', '\App\Http\Controllers\Service\Auth\ApiLoginController@login');
	
	Route::name('relogin')
		->post('relogin', '\App\Http\Controllers\Service\Auth\ApiLoginController@relogin');
		
	Route::name('logout')->any('logout', '\App\Http\Controllers\Service\Auth\ApiLoginController@logout');
});