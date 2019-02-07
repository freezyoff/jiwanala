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
		->post('/delete', '\App\Http\Controllers\My\Bauk\HolidayController@delete');
});

Route::prefix('attendance')
	->name('attendance')
	->group(function(){
	
	Route::prefix('fingers')
		->name('.fingers')
		->middleware('permission:bauk.attendance.post')
		->group(function(){	
		Route::get('{nip}/{year}/{month}/{day}', '\App\Http\Controllers\My\Bauk\Attendance\AttendanceFingerController@show');
		Route::post('{nip}/{year}/{month}/{day}', '\App\Http\Controllers\My\Bauk\Attendance\AttendanceFingerController@post');
	});
	
	Route::prefix('consent')
		->name('.consents')
		->middleware('permission:bauk.attendance.post')
		->group(function(){	
		Route::get('{nip}/{year}/{month}/{day}', '\App\Http\Controllers\My\Bauk\Attendance\AttendanceConsentController@show');
		Route::post('{nip}/{year}/{month}/{day}', '\App\Http\Controllers\My\Bauk\Attendance\AttendanceConsentController@post');
		
		Route::name('.preview')
			->post('preview/file', '\App\Http\Controllers\My\Bauk\Attendance\AttendanceConsentController@previewFile');
	});
		
	Route::middleware('permission:bauk.attendance.post')
		->name('.upload')
		->get('/upload', '\App\Http\Controllers\My\Bauk\AttendanceController@showUpload');
		
	
	//diurutkan seperti ini dengan tujuan urutan routing.
	//WARNING: jangan dirubah urutannya
	Route::middleware('permission:bauk.list.employee')
		->name('.search.employee')
		->post('search/employee', '\App\Http\Controllers\My\Bauk\AttendanceController@searchEmployee');
	Route::name('.landing')
		->middleware('permission:bauk.attendance.list')
		->get('{nip?}/{year?}/{month?}', '\App\Http\Controllers\My\Bauk\AttendanceController@landing');
		
});