<?php 

Route::name('auth.')
	->group(function(){
	Route::name('login')
		->post('login', '\App\Http\Controllers\Service\Auth\LoginController@loginApi');
	Route::name('logout')
		->any('logout', '\App\Http\Controllers\Service\Auth\LoginController@logoutApi');
});