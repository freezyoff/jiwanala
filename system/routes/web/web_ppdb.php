<?php

Route::name('landing')
	->middleware(['guest:ppdb'])
	->get('', function(){
		return view('ppdb.landing');
	});

Route::name('dashboard.landing')
	->middleware(['auth:ppdb'])
	->any('dashboard', function(){
		\Auth::guard('ppdb')->logout();
	return "dashboard";
});