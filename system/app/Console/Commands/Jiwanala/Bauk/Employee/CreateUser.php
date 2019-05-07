<?php

namespace App\Console\Commands\Jiwanala\Bauk\Employee;

use Illuminate\Console\Command;
use App\Libraries\Bauk\Employee;
use App\Libraries\Service\Auth\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-employee:grantUser {employee_nip}
							{--remote	: target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User for given employee';

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
		return $this->option('remote')? true : false;
	}
	
	function createUserData($employee){
		return [
			'name'=>		$employee->nip,
			'email'=>		$employee->getEmailDefault(),
		];
	}
	
	function getUser($data){
		if ($this->isRemote()){
			return User::on($this->remoteConnection('_remoteUser','jiwanala_service'))
				->firstOrNew(['name'=>$data['name'], 'email'=>$data['email']]);
		}
		else{
			return User::firstOrNew(['name'=>$data['name'], 'email'=>$data['email']]);
		}
	}
	
	function getPasswordBroker(){
		return $this->option('remote')? $this->createPasswordBroker() : \Password::broker()->getRepository();
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
	
	public function handle(){
		$nip = $this->argument('employee_nip');
		$employee = $this->isRemote()? 
			Employee::on($this->remoteConnection('_remote_employee', 'jiwanala_bauk'))->where('nip',$nip)->first() : 
			Employee::findByNIP($nip);
		
		$email = $employee->getEmailDefault();
		if (!$email){
			$this->error('User for Employee NIP: '.$employee->nip.' does not have email!');
		}
		elseif ($employee && $employee->getEmailDefault()){
			$data = $this->createUserData($employee);
			if ($this->isRemote()){
				$data['--remote'] = true;
			}
			
			//create user
			$this->call('jn-user:add', $data, $this->output);
			
			$user = $this->getUser($data);
			if ($user->exists){
				$employee->user_id = $user->id;
				$employee->save();
			}
			else{
				//error on create user
				$this->error('Error on creating user for Employee NIP: <fg=yellow>'.$nip.'</>');
			}
		}
		else{
			$this->error('Employee NIP: '.$nip.' Not Found');
		}		
	}
}
