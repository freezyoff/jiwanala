<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Role records in database. Install new Role if available';

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
			
			$dbCurrent = Role::firstOrNew(['id'=>$key],$data);
			$exists = $dbCurrent->exists;
			if (!$exists){
				$dbCurrent->save();
			}
			$this->line('<fg=cyan>'.($exists? 'Sync' : 'Add ').'</> Role Context:<fg=green>'.$dbCurrent->context.'</> id:<fg=yellow>'.$dbCurrent->id.'</>');
			
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
			$dbCurrent->permissions()->sync($dbCurrentPermissions);
			foreach($dbCurrentPermissions as $permission){
				$this->line('<fg=cyan>'.($exists? 'Sync':'Add ').'</> Role:<fg=green>'.$dbCurrent->id.'</> -> Permission:<fg=yellow>'.$permission.'</>');
			}
		}
    }
}
