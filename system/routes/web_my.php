<?php

//domain my.jiwa-nala.org

Route::name('my.dashboard')->group(function(){
	
	Route::get('/', function () { 
		return view('my.dashboard');
	});
});

Route::name('bauk')
	->prefix('bauk')
	->group(function(){
	
	Route::get('/',function(){	
		return view('bauk.default.landing'); 
	});
	
	Route::name('.mnjkaryawan')
		->prefix('mnjkaryawan')
		->group(function(){
			
		Route::get('/', function(){ 
			return view('bauk.default.mnjkaryawan.landing'); 
		});
		
		Route::name('.tambah')
			->prefix('tambah')
			->group(function(){
				
			Route::get('/', function(){ return view('bauk.default.mnjkaryawan.tambah'); });
			Route::post('/', '\App\Http\Controllers\BAUK\MnjKaryawanController@save');
		});
		
		Route::put('/rubah', '\App\Http\Controllers\BAUK\MnjKaryawanController@update')->name('.rubah');
		Route::delete('/hapus', '\App\Http\Controllers\BAUK\MnjKaryawanController@delete')->name('.hapus');
		Route::get('/unggah', '\App\Http\Controllers\BAUK\MnjKaryawanController@upload')->name('.unggah');
		Route::post('/ekspor', '\App\Http\Controllers\BAUK\MnjKaryawanController@export')->name('.ekspor');
		
		Route::name('.layanan')
			->prefix('layanan')
			->group(function(){
				
			Route::post('/isUniqueNIP', '\App\Http\Controllers\BAUK\MnjKaryawanController@isUniqueNIP')->name('.uniqueNIP');				
			Route::post('/getTableDataKarayawan', '\App\Http\Controllers\BAUK\MnjKaryawanController@getTableDataKarayawan')->name('.getTableDataKarayawan');
		});
	});
	
});