<?php

//domain= my.jiwa-nala.org
//parent route= my

Route::name('dashboard')
	->group(function(){
	
	Route::get('/', function () {
		return view('my.dashboard');
	});
	
});

Route::prefix('service')
	->name('service')
	->middleware(['role:administrator'])
	->group(function(){
	
	
	
});