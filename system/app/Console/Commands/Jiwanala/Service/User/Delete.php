<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:delete {email}
							{--remote 	: target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete User Account';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function remoteConnection($connectionKey, $database){
		config(['database.connections.'.$connectionKey => [
			'driver' => 	env('DB_REMOTE_DRIVER'),
			'host' => 		env('DB_REMOTE_HOST'),
			'username' => 	env('DB_REMOTE_USERNAME'),
			'password' => 	env('DB_REMOTE_PASSWORD'),
			'database' => 	$database,
		]]);
		
		return $connectionKey;
	}
	
	function isRemote(){
		return $this->option('remote');
	}
	
	function getUser($email){
		return $this->isRemote()?
			User::on($this->remoteConnection('_remoteUser'), 'jiwanala_service')->where('email', $email)->first() : 
			User::where('email',$email)->first();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		$email = $this->argument('email');
        $user = $this->getUser($email);
		if ($user){
			$user->delete();
			$this->line('User Name: <fg=green>'.$user->name.'</> Email: <fg=yellow>'.$user->email.'</> <fg=red>removed</>');
		}
		else{
			$this->error('User registered with Email: '.$email.' not yet created!');
		}
    }
}
