<?php

/*
\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
    echo'<pre>';
    var_dump($query->sql);
    var_dump($query->bindings);
    var_dump($query->time);
    echo'</pre>';
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$domain = 'jiwa-nala';
if (App::environment('local')){
	$domain .= '.local';
}
else{
	$domain .= '.'. App::environment();
}

Route::domain('my.'.$domain)->group(function () {
    Route::get('/layout', function(){
		return view('layouts.default.defaultLayout');
	});
	
	Route::name('dashboard')->group(function(){
		Route::get('/', function () { 
			return view('dashboard.default.defaultDashboard'); 
		});
	});
	
	Route::name('bauk')->prefix('bauk')
		->group(function(){
		
		Route::get('/',function(){	
			return view('bauk.default.landing'); 
		});
		
		Route::name('.mnjkaryawan')->prefix('mnjkaryawan')
			->group(function(){
				
			Route::get('/', function(){ 
				return view('bauk.default.mnjkaryawan.landing'); 
			});
			
			Route::name('.tambah')->prefix('tambah')->group(function(){
				Route::get('/', function(){ return view('bauk.default.mnjkaryawan.tambah'); });
				Route::post('/', '\App\Http\Controllers\BAUK\MnjKaryawanController@save');
			});
			
			Route::name('.uniqueNIP')->prefix('isUniqueNIP')->group(function(){
				Route::post('/', '\App\Http\Controllers\BAUK\MnjKaryawanController@isUniqueNIP');
			});
		});
		
	});
	
});