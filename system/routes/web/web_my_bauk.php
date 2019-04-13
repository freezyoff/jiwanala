<?php 
Route::name('landing')
	->group(function(){
	Route::get('/', '\App\Http\Controllers\My\BaukController@landing');
		
	Route::prefix('info')
		->name('.info')
		->group(function(){
		Route::name('.nextHolidays')
			->post('nextHolidays', '\App\Http\Controllers\My\BaukController@nextHolidays');
		Route::name('.employeesCount')
			->post('employeesCount', '\App\Http\Controllers\My\BaukController@employeesCount');	
		Route::name('.attendanceProgress')
			->post('attendanceProgress', '\App\Http\Controllers\My\BaukController@attendanceProgress');
		Route::name('.employeeWithNoSchedules')
			->post('employeeWithNoSchedules', '\App\Http\Controllers\My\BaukController@employeeWithNoSchedules');
		
		Route::name('.fingerConsent')
			->post('fingerConsent', '\App\Http\Controllers\My\BaukController@fingerConsent');
			
	});
});
	
Route::prefix('employee')
	->name('employee')
	->group(function(){
	
	Route::name('.landing')
		->any('/', '\App\Http\Controllers\My\Bauk\EmployeeController@landing');
	
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
	
	Route::prefix('deactivate')
		->name('.deactivate')
		->middleware('permission:bauk.patch.employee')
		->group(function(){
		Route::get('deactivate/{id}/{date}', '\App\Http\Controllers\My\Bauk\EmployeeController@deactivate');
	});
});

Route::prefix('schedule')
	->name('schedule')
	->middleware(['permission:bauk.schedule.post','permission:bauk.schedule.delete'])
	->group(function(){
	Route::name('.landing')
		->any('/', '\App\Http\Controllers\My\Bauk\ScheduleController@index');
	Route::name('.store')
		->post('/add', '\App\Http\Controllers\My\Bauk\ScheduleController@store');
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
		
	Route::prefix('download')
		->name('.download')
		->group(function(){
		Route::name('.template')
			->get('/template/{type}', '\App\Http\Controllers\My\Bauk\AttendanceController@download_template');
		Route::name('.help')
			->get('/help/{type}', '\App\Http\Controllers\My\Bauk\AttendanceController@download_help');
	});
	
	Route::name('.upload')
		->middleware('permission:bauk.attendance.post')
		->group(function(){
		Route::get('/upload', '\App\Http\Controllers\My\Bauk\AttendanceController@showUpload');
		Route::post('/upload', '\App\Http\Controllers\My\Bauk\AttendanceController@upload');
	});
	
	Route::middleware('permission:bauk.list.employee')
		->name('.search.employee')
		->post('search/employee', '\App\Http\Controllers\My\Bauk\AttendanceController@searchEmployee');
		
	Route::prefix('histories')
		->middleware('permission:bauk.attendance.list')
		->group(function(){
			
		Route::name('.landing')
			->middleware('permission:bauk.attendance.list')
			->get('{nip?}/{year?}/{month?}', '\App\Http\Controllers\My\Bauk\AttendanceController@landing');
			
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
	});
	
	Route::prefix('summary')
		->name('.summary')
		->middleware('permission:bauk.attendance.list')
		->group(function(){
		
		Route::name('.landing')
			->get('', '\App\Http\Controllers\My\Bauk\Attendance\SummaryController@index');
		
	});
	
	Route::name('.report')
		->prefix('report')
		->middleware('permission:bauk.attendance.report')
		->group(function(){
		
		Route::name('.landing')
			->get('', '\App\Http\Controllers\My\Bauk\Attendance\ReportController@index');
		
		Route::name('.attendance')
			->post('attendance/monthly', '\App\Http\Controllers\My\Bauk\Attendance\ReportController@monthlyReport');
		
		Route::name('.summary')
			->post('attendance/summary', '\App\Http\Controllers\My\Bauk\Attendance\ReportController@summaryReport');
	});
		
});

Route::name('assignment.')
	->prefix('assignment')
	->group(function(){
	
	Route::name('landing')
		->middleware('permission:bauk.assignment.list')
		->any('', '\App\Http\Controllers\My\Bauk\AssignmentController@index');
	
	Route::name('assign')
		->middleware('permission:bauk.assignment.assign')
		->get('assign/{employeeNIP}/at/{divisionCode}', '\App\Http\Controllers\My\Bauk\AssignmentController@assignAt');
	
	Route::name('assign.as')
		->middleware('permission:bauk.assignment.assign')
		->get('assign/{employeeNIP}/at/{divisionCode}/as/{jobPositionCode}', '\App\Http\Controllers\My\Bauk\AssignmentController@assignAs');
	
	Route::name('release')
		->middleware('permission:bauk.assignment.release')
		->get('release/{employeeNIP}/from/{divisionCode}', '\App\Http\Controllers\My\Bauk\AssignmentController@releaseFrom');
		
	Route::name('release.as')
		->middleware('permission:bauk.assignment.release')
		->get('release/{employeeNIP}/from/{divisionCode}/as/{jobPositionCode}', '\App\Http\Controllers\My\Bauk\AssignmentController@releaseAs');
});