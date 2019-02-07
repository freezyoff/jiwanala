<?php

Route::get('/', function(){ 
	return view('my.service.landing'); 
})->name('landing');