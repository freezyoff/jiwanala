<?php 

Route::prefix('bauk')
	->name('bauk.')
	->group(function(){
	
	Route::apiResource('attendance','\App\Http\Controllers\My\Bauk\APIAttendanceController');
	
	Route::name('attendance.fingers')
		->get('attendance/finger/{year}/{month}/{day}', function(){
			
		});
		
	Route::name('attendance.consents')
		->get('attendance/consents/{year}/{month}/{day}', function(){
			
		});
});

Route::get('/test', function(\Illuminate\Http\Request $request){
	return response()->json([
		'code'=>200,
		'user'=>\Auth::user()->name,
	],200);
});