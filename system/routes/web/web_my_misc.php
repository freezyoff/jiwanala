<?php

Route::name('upload')->group(function(){
	Route::post('upload', '\App\Http\Controllers\My\Misc\ResourceController@upload');
});

Route::name('search.')
	->group(function(){
		
	Route::name('employee')
		->middleware('permission:bauk.employee.list')
		->post('search/employee', '\App\Http\Controllers\My\Misc\SearchController@searchEmployee');
	
	Route::name('student')
		->middleware('permission:baak.student.list')
		->post('search/student', '\App\Http\Controllers\My\Misc\SearchController@searchStudent');
});