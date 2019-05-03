<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install predefined Roles and its permissions';

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
        foreach(config('role') as $key=>$role){
			
			$only = ['context','display_name','description'];
			$data = array_filter(
				$role,
				function ($key) use ($only) {
					return in_array($key, $only);
				},
				ARRAY_FILTER_USE_KEY
			);
			$data['id'] = $key;
			
			$this->call('jn-role:add', $data, $this->output);
			//$dbCurrent = Role::create($data);
			
			//adding permissions 
			$dbCurrentPermissions = [];
			
			//extend from role
			if (isset($role['roles'])){
				foreach($role['roles'] as $extend){
					$dbRole = Role::find($extend);
					$dbCurrentPermissions = $dbRole->permissions()->get()
						->flatten(1)
						->map(function($item, $key){
							return $item['id'];
						})->all();
				}				
			}
			
			//handle permissions
			if (isset($role['permissions'])){
				foreach($role['permissions'] as $permission){
					if (!in_array($permission, $dbCurrentPermissions)){
						$dbCurrentPermissions[] = $permission;
					}
				}
			}
			
			//insert
			$this->call('jn-role:grant', [
				'role_id'=>$data['id'],
				'permission_id'=>$dbCurrentPermissions
			], $this->output);
		}
    }
}
