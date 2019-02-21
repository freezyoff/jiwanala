<?php 

Route::prefix('android')
	->name('android')
	->group(function(){
	//Route::apiResource('attendance','\App\Http\Controllers\My\Api\APIAttendanceController');
	
	Route::any('attendance/histories', '\App\Http\Controllers\My\Api\APIAttendanceController@index');
	
});

Route::get('/test', function(\Illuminate\Http\Request $request){
	return response()->json([
		'code'=>200,
		'user'=>\Auth::user()->name,
	],200);
});