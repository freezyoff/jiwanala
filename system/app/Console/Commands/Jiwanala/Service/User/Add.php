<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:add {name} {email}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
	
	function isRemote(){
		return $this->option('remote')? true : false;
	}
	
	function getUser($name, $email){
		if ($this->isRemote()){
			return User::on($this->remoteConnection('_remoteUser','jiwanala_service'))
				->firstOrNew(['name'=>$name, 'email'=>$email]);
		}
		else{
			return User::firstOrNew(['name'=>$name, 'email'=>$email]);
		}
	}
	
	function validateEmail($email){
		$email = $this->isRemote()?
			User::on($this->remoteConnection('_remoteUser','jiwanala_service'))->where('email',$email)->first() : 
			User::where('email',$email)->first();
			
		return $email? true : false;
	}
	
	function validateName($name){
		$email = $this->isRemote()?
			User::on($this->remoteConnection('_remoteUser','jiwanala_service'))->where('name',$name)->first() : 
			User::where('name',$name)->first();
			
		return $email? true : false;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$name = $this->argument('name');
		$email = $this->argument('email');
		
		if ($this->validateName($name)){
			$this->error('User Name: '.$name.' already registered!');
		}
		elseif ($this->validateEmail($email)){
			$this->error('User Email: '.$email.' already registered!');
		}
		else{
			$this->createUser($name, $email);
		}
    }
	
	function createUser($name, $email){
		
		$user = $this->getUser($name, $email);
		
		if ($user->exists){
			$this->error('User Name: '.$user->name.' & Email: '.$user->email.' already registered!');
		}
		else{			
			$data =[ 
				'name'=>$name, 
				'email'=>$email, 
				'activated'=>1 
			];	
			$user = $user->fill($data);
			$user->save();
			
			$user->sendNewUserInvitationNotification($this->getPasswordBroker()->create($user));
			
			$this->line('User Name: <fg=yellow>'.$user->name.'</> Email: <fg=yellow>'.$user->email.'</> created!');
			$this->line('<fg=green>Invitation email</> has been sended.');
		}
	}
}
