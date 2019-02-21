<?php 

Route::prefix('android')
	->name('android')
	->group(function(){
		
	Route::any('attendance/histories', '\App\Http\Controllers\My\Api\AndroidController@index');
	Route::any('attendance/statistics', '\App\Http\Controllers\My\Api\AndroidController@statistics');
	
});

Route::get('/test', function(\Illuminate\Http\Request $request){
	return response()->json([
		'code'=>200,
		'user'=>\Auth::user()->name,
	],200);
});