<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;

class ResetPwd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:resetPwd {email : user email}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset User Password';

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
	
	function getUser($email){
		return $this->isRemote()?
			User::on($this->remoteConnection('_remoteUser'), 'jiwanala_service')->where('email', $email)->first() : 
			User::where('email',$email)->first();
	}
	
	function isRemote(){
		return $this->option('remote');
	}
	
	function getPasswordBroker(){
		return $this->isRemote()? $this->createPasswordBroker() : \Password::broker()->getRepository();
	}
	
	function createPasswordBroker(){
		$key = config('app.key');
		if (\Illuminate\Support\Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }
		
		$name = config('auth.defaults.passwords');
		$config = config('auth.passwords.'.$name);
		return new \Illuminate\Auth\Passwords\DatabaseTokenRepository(
            \DB::connection($this->remoteConnection('_remoteResetPassword','jiwanala_service')),
            app('hash'),
            $config['table'],
            $key,
            $config['expire']
        );
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$email = $this->argument('email');
        $registeredUser = $this->getUser($email);
		if ($registeredUser){
			$registeredUser->sendPasswordResetNotification($this->getPasswordBroker()->create($registeredUser));
			$this->line('<fg=cyan>Reset password link</> has been send to email: <fg=yellow>'.$email.'</>');
		}
		else{
			$this->error('User with Email: '. $email .' not registered!');
		}
    }
}
