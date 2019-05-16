<?php 

Route::name('landing')
	->get('', '\App\Http\Controllers\My\BaakController@index');
	
Route::name('student.')
	->prefix('student')
	->group(function(){
	
	Route::name('landing')->get('', '\App\Http\Controllers\My\Baak\StudentController@index');
	Route::prefix('add')
		->middleware('permission:baak.student.post')
		->middleware('permission:baak.student.patch')
		->group(function(){
			
		Route::name('add')->get('', '\App\Http\Controllers\My\Baak\StudentController@add');
		Route::name('store')->post('', '\App\Http\Controllers\My\Baak\StudentController@store');
		
	});
});