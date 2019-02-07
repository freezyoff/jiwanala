<?php

Route::name('upload')->group(function(){
	Route::post('upload', '\App\Http\Controllers\My\Misc\ResourceController@upload');
});