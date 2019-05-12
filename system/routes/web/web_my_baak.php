<?php 

Route::name('landing')
	->get('', '\App\Http\Controllers\My\BaakController@index');
	
Route::name('student.')
	->prefix('student')
	->group(function(){
	
	Route::name('landing')->get('', '\App\Http\Controllers\My\Baak\StudentController@index');
	
});