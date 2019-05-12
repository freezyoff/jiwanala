<?php

Route::prefix('misc')
	->name('misc.')
	->group(base_path('routes/web/web_my_misc.php'));

Route::prefix('system')
	->name('system.')
	->middleware(['permission.context:system'])
	->group(base_path('routes/web/web_my_system.php'));

Route::prefix ('bauk')
	->name('bauk.')
	->middleware(['permission.context:bauk'])
	->group(base_path('routes/web/web_my_bauk.php'));

Route::prefix ('baak')
	->name('baak.')
	->middleware(['permission.context:baak'])
	->group(base_path('routes/web/web_my_baak.php'));
	
Route::prefix('dashboard')
	->name('dashboard.')
	->group(base_path('routes/web/web_my_dashboard.php'));