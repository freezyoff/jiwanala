<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
		/*
		Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
			 
		*/
		
		Route::middleware('web')
			->namespace($this->namespace)
			->group(function(){
				
			 $domain = $this->getDomain();
			 $this->mapWebDomainMy($domain);
			 $this->mapWebDomainService($domain);
			 
		 });
    }
	
	protected function mapWebDomainService($domain){
		Route::domain('service.'.$domain)
			->name('service.')
			->middleware('web')
			->group(base_path('routes/web_service.php'));
	}
	
	protected function mapWebDomainMy($domain){
		Route::domain('my.'.$domain)
			->middleware(['auth', 'timezone'])
			->name('my.')
			->group(base_path('routes/web_my.php'));
	}

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
	
	protected function getDomain(){
		$domainBase = 'jiwa-nala';
		return $domainBase . (\App::environment('production')? '.org' : '.local');
	}
}
