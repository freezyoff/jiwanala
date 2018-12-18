<?php 
Route::name('landing')->get('/', '\App\Http\Controllers\My\BaukController@landing');
	
Route::prefix('employee')
	->name('employee')
	->group(function(){
	
	Route::any('/', '\App\Http\Controllers\My\Bauk\EmployeeController@landing');
	
	/*
	Route::name('.generate.nip')
		->get('/get/nip', '\App\Http\Controllers\My\Bauk\EmployeeController@generateNIP');
	*/
	
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
		->group(function(){
		
		Route::get('{id}', '\App\Http\Controllers\My\Bauk\EmployeeController@patchView');
		Route::post('{id}', '\App\Http\Controllers\My\Bauk\EmployeeController@patch');
	});
	
	Route::prefix('delete')
		->name('.delete')
		->middleware('permission:bauk.delete.employee')
		->group(function(){
		Route::get('{id}', '\App\Http\Controllers\My\Bauk\EmployeeController@delete');
	});
	
	Route::prefix('activate')
		->name('.activate')
		->middleware('permission:bauk.patch.employee')
		->group(function(){
		Route::get('{id}/{activationFlag?}', '\App\Http\Controllers\My\Bauk\EmployeeController@activate');
	});
});

Route::prefix('holiday')
	->name('holiday')
	->group(function(){

	Route::name('.landing')
		->middleware('permission:bauk.holiday.list')
		->group(function(){
		Route::get('/', '\App\Http\Controllers\My\Bauk\HolidayController@landing');
		Route::post('/', '\App\Http\Controllers\My\Bauk\HolidayController@landing');
	});
	
	Route::name('.add')
		->prefix('add')
		->middleware('permission:bauk.holiday.post')
		->group(function(){
		Route::middleware('permission:bauk.holiday.post')
			->get('', '\App\Http\Controllers\My\Bauk\HolidayController@showAdd');
		Route::middleware('permission:bauk.holiday.post')
			->post('', '\App\Http\Controllers\My\Bauk\HolidayController@add');
	});
	
	Route::name('.edit')
		->prefix('edit')
		->middleware('permission:bauk.holiday.patch')
		->group(function(){
		Route::middleware('permission:bauk.holiday.patch')
			->get('{id}', '\App\Http\Controllers\My\Bauk\HolidayController@showEdit');
		Route::middleware('permission:bauk.holiday.patch')
			->post('{id}', '\App\Http\Controllers\My\Bauk\HolidayController@edit');
	});
	
	Route::name('.delete')
		->middleware('permission:bauk.holiday.delete')
		->get('/delete/{id}', '\App\Http\Controllers\My\Bauk\HolidayController@delete');
});

Route::prefix('attendance')
	->name('attendance')
	->group(function(){
	
	Route::middleware('permission:bauk.attendance.list')
		->group(function(){
		Route::name('.landing')
			->get('', '\App\Http\Controllers\My\Bauk\EmployeeAttendanceController@landing');
			
		Route::name('.landing')
			->get('', '\App\Http\Controllers\My\Bauk\EmployeeAttendanceController@landing');		
	});
	
	Route::middleware('permission:bauk.list.employee')
		->name('.search.employee')
		->post('search/employee', '\App\Http\Controllers\My\Bauk\EmployeeAttendanceController@searchEmployee');

			
	Route::middleware('permission:bauk.attendance.post')
		->name('.upload')
		->get('/upload', '\App\Http\Controllers\My\Bauk\EmployeeAttendanceController@showUpload');
		
});