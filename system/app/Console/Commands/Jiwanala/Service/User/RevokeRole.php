<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;
use App\Libraries\Service\Role;

class RevokeRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:revokeRole {user_name} {role_id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke given Roles from given User';

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
        $name = $this->argument('user_name');
		$user = User::findByName($name);
		if (!$user){
			$this->line('Username <fg=cyan>'.$this->argument('user_name').'</> <fg=red>not found</>');
			exit;
		}
		
		$this->line('Revoke Role from <fg=cyan>'.$name.'</>');
		foreach($this->argument('role_id') as $role){
			//check if given role valid id
			if (Role::find($role)){
				$user->revokeRole($role);
				$this->line('Role <fg=green>'.$role.'</> <fg=yellow>Revoked</>');
			}
			else{
				$this->line('Role <fg=green>'.$role.'</> <fg=red>Not Found</>');
			}
		}
    }
}
