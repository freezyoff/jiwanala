<?php

//domain= my.jiwa-nala.org
//parent route= my

Route::name('dashboard')
	->group(function(){
	
	Route::get('/', function () {
		return view('my.landing');
	});
	
});

Route::prefix('service')
	->name('service.')
	->middleware(['permission.context:service'])
	->group(function(){
	
	//service for administer user and job
	//@TODO create service
	
	Route::get('/', function(){ 
		return view('my.service.landing'); 
	})->name('landing');
	
});

Route::prefix ('bauk')
	->name('bauk.')
	->middleware(['permission.context:bauk'])
	->group(function(){
		
	Route::name('landing')->get('/', '\App\Http\Controllers\My\BaukController@landing');
	Route::prefix('get')
		->name('get')
		->middleware('permission:bauk.get')
		->get('patch', '\App\Http\Controllers\My\BaukController@get');
	
	Route::prefix('employee')
		->name('employee')
		->group(function(){
		
		Route::get('/', '\App\Http\Controllers\My\Bauk\EmployeeController@landing');
		Route::name('.generate.nip')
			->get('/get/nip', '\App\Http\Controllers\My\Bauk\EmployeeController@generateNIP');
		
		Route::prefix('add')
			->name('.add')
			->middleware('permission:bauk.post.employee')
			->group(function(){
			Route::get('/', '\App\Http\Controllers\My\Bauk\EmployeeController@postView');
			Route::post('/', '\App\Http\Controllers\My\Bauk\EmployeeController@post');
		});
		
		Route::prefix('edit')
			->name('.edit')
			->middleware('permission:bauk.patch.employee')
			->group(function($id){
			
			Route::get('{id}', '\App\Http\Controllers\My\Bauk\EmployeeController@patchView');
			Route::post('{id}', '\App\Http\Controllers\My\Bauk\EmployeeController@patch');
		});
	});
	
});