<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class GrantPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:grant {role_id} {permission_id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant permission to given role';

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
        foreach($this->argument('permission_id') as $permission_id){
			$role = Role::find($this->argument('role_id'));
			if ($role){
				$role->permissions()->attach($permission_id);
				$this->line('<fg=cyan>Grant</> Role:<fg=green>'.$role->id.'</> -> Permission:<fg=yellow>'.$permission_id.'</>');
			}
			else{
				$this->error('Role id: '.$this->argument('role_id').' Not Found');
			}
		}
    }
}
