<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;
use App\Libraries\Service\Role;
use App\Libraries\Service\Permissions;

class ListRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:listRole {user_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Roles granted to given username';

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
		
		$data = $user->roles()->get()
				->map(function($item, $key){
					return [
						$item['id'], 
						$item['context']
					];
				})->all();
		
		$this->table(['Role', 'Context'],$data);
    }
}
