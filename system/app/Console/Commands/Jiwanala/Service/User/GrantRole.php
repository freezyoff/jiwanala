<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;
use App\Libraries\Service\Role;
use Illuminate\Support\Str;

class GrantRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:grantRole {user_name} {role_id*} 
							{--role-opt		: add role option in grant process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant Role to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function serializeRoleOptions($roleID){
		$roleOptions = [];
		$choice = $this->choice('Add Role <fg=yellow>'.$roleID .'</> Option?', ['Yes', 'No'], 0);
		while (strtolower($choice) == strtolower('yes')){
			$key = $this->ask('Option array <fg=yellow>Key</> (use dot notation if nested array)?');
			$value = $this->ask('Option array <fg=yellow>Value</>?');
			if (!empty($key)){
				data_fill($roleOptions, $key, $value);				
			}
			else{
				$this->line('Empty option key. Option <fg=red>not added</>');
			}
			$choice = $this->choice('Add more Role Option?', ['Yes', 'No'], 0);
		}
		
		return $roleOptions;
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
		
		$this->line('Grant Role to <fg=cyan>'.$name.'</>');
		foreach($this->argument('role_id') as $role){
			//check if given role valid id
			if (Role::find($role)){
				
				$user->grantRole($role, $this->serializeRoleOptions($role));
				$this->line('Role <fg=green>'.$role.'</> <fg=yellow>Granted</>');
			}
			else{
				$this->line('Role <fg=green>'.$role.'</> <fg=red>Not Found</>');
			}
		}
    }
}
