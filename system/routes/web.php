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
	$domain .= '.org';
}

Route::domain('bimbel.'.$domain)->group(function () {
	Route::get('/', function(){
		return "bimbel.jiwa-nala.local";
	});
});

Route::domain('my.'.$domain)->group(function () {
    
	/*
	Route::get('/layout', function(){
		return view('layouts.default.defaultLayout');
	});
	*/
	Route::name('web')->group(function(){
		Route::get('/web', function () { 
			return view('web.landing'); 
		});
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
		
		Route::name('.mnjkaryawan')->prefix('mnjkaryawan')->group(function(){
				
			Route::get('/', function(){ 
				return view('bauk.default.mnjkaryawan.landing'); 
			});
			
			Route::name('.tambah')->prefix('tambah')->group(function(){
				Route::get('/', function(){ return view('bauk.default.mnjkaryawan.tambah'); });
				Route::post('/', '\App\Http\Controllers\BAUK\MnjKaryawanController@save');
			});
			
			Route::put('/rubah', '\App\Http\Controllers\BAUK\MnjKaryawanController@update')->name('.rubah');
			Route::delete('/hapus', '\App\Http\Controllers\BAUK\MnjKaryawanController@delete')->name('.hapus');
			Route::get('/unggah', '\App\Http\Controllers\BAUK\MnjKaryawanController@upload')->name('.unggah');
			Route::post('/ekspor', '\App\Http\Controllers\BAUK\MnjKaryawanController@export')->name('.ekspor');
			
			Route::name('.layanan')->prefix('layanan')->group(function(){
				Route::post('/isUniqueNIP', '\App\Http\Controllers\BAUK\MnjKaryawanController@isUniqueNIP')->name('.uniqueNIP');				
				Route::post('/getTableDataKarayawan', '\App\Http\Controllers\BAUK\MnjKaryawanController@getTableDataKarayawan')->name('.getTableDataKarayawan');
			});
		});
		
	});
	
});