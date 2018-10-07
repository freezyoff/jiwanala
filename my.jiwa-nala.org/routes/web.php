<?php

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
	
	Route::name('dashboard.')->group(function(){
		Route::get('/', function () { 
			return view('dashboard.default.defaultDashboard'); 
		})->name('landing');
	});
	
	Route::name('bauk.')
		->prefix('bauk')->group(function(){
		
		Route::get('/',function(){	
			return view('bauk.default.landing'); 
		})->name('landing');
		
		Route::get('/mnjkaryawan', function(){ 
			return view('bauk.default.mnjkaryawan.landing'); 
		})->name('mnjkaryawan');
		
	});
	
});