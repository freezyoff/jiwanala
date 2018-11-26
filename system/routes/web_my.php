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
	
	//service for administer user and job
	//@TODO create service
	
});

Route::prefix ('bauk')
	->name('bauk')
	->middleware(['role:bauk'])
	->group(function(){
		
	Route::get('', '\App\My\BaukController@landing');
	Route::prefix('get')
		->name('.get')
		->middleware('permission:bauk.get')
		->get('patch', '\App\My\BaukController@get');
		
	Route::prefix('post')
		->name('.post')
		->middleware('permission:bauk.post')
		->group(function(){
		Route::get('post', '\App\My\BaukController@post');
		Route::post('post', '\App\My\BaukController@post');
	});
	Route::prefix('patch')
		->middleware('permission:bauk.patch')
		->group(function(){
		Route::get('patch', '\App\My\BaukController@patch');
		Route::post('patch', '\App\My\BaukController@patch');
	});
});