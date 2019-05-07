<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use \App\Libraries\Service\Permission;

class ListPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:list
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered permissions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table(
			['ID','Context', 'Display Name', 'Descriptions'], 
			$this->getPermissions()->map(function($item){
				return collect($item)->only(['id','context','display_name','description']);
			})
		);
    }
	
	function getPermissions(){
		return $this->option('remote')? $this->getPermissionsOnRemote() : $this->getPermissionsOnLocal();
	}
	
	function getPermissionsOnRemote(){
		config(['database.connections._permissionRemote' => [
			'driver' => 	env('DB_REMOTE_DRIVER'),
			'host' => 		env('DB_REMOTE_HOST'),
			'username' => 	env('DB_REMOTE_USERNAME'),
			'password' => 	env('DB_REMOTE_PASSWORD'),
			'database' => 	'jiwanala_service',
		]]);
		return collect(Permission::on('_permissionRemote')->get());
	}
	
	function getPermissionsOnLocal(){
		return collect(Permission::all());
	}
}
