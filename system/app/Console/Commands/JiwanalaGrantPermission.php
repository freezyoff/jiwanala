<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JiwanalaGrantPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:grant {user : username} {permissions* : permission list to grant}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grant user the given permission';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){ parent::__construct(); }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		$user = \App\Libraries\Service\Auth\User::where('name','=',$this->argument('user'))->first();
		if ($user){
			$this->comment('Process granting permission(s):');
			foreach($this->argument('permissions') as $permissionKey){
				$user->grantPermissions($permissionKey);
				$this->info('Permission key: '.$permissionKey.' added.');
			}			
		}
		else {
			$this->error('                      ');
			$this->error('    User not found    ');
			$this->error('                      ');
		}
    }
}
