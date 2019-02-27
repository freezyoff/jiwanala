<?php

Route::name('upload')->group(function(){
	Route::post('upload', '\App\Http\Controllers\My\Misc\ResourceController@upload');
});

Route::name('search.')
	->group(function(){
		
	Route::name('employee')
		->middleware('permission:bauk.list.employee')
		->post('search/employee', '\App\Http\Controllers\My\Misc\SearchController@searchEmployee');
	
});