<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
		//\Carbon\Carbon::setLocale(config('app.locale'));
		
		//force ssl
		if (env('APP_ENV') === 'production') {
			//$this->app['request']->server->set('HTTPS', true);
			URL::forceScheme('https');
		}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
