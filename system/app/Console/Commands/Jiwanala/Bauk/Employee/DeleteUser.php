<?php

namespace App\Console\Commands\Jiwanala\Bauk\Employee;

use Illuminate\Console\Command;
use App\Libraries\Bauk\Employee;
use App\Libraries\Service\Auth\User;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-employee:revokeUser {employee_nip}
							{--remote	: target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove/Delete User wich associate to given employee';

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
	
	function getUser($employee){
		if ($this->isRemote()){
			$con = $this->remoteConnection('_remote_user', 'jiwanala_service');
			return User::on($con)->where('id', $employee->user_id)->first();
		}
		else{
			return User::where('id',$employee->user_id)->first();
		}
		return false;
	}
	
	function isRemote(){
		return $this->option('remote')? true : false;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$isRemote = $this->isRemote();
		$nip = $this->argument('employee_nip');
		
		$employee = $isRemote? 
			Employee::on($this->remoteConnection('_remote_employee', 'jiwanala_bauk'))->where('nip', $nip)->first() : 
			Employee::findByNIP($nip);
		
		if ($employee && $employee->user_id){
			$data = [
				'--remote'=>$isRemote
			];
		
			$data['email'] = $this->getUser($employee)->email;
			$employee->user_id = null;
			$employee->save();
			$this->call('jn-user:delete',$data, $this->output);
		}
		elseif (is_null($employee->user_id)){
			$this->error('Employee NIP: '.$nip.' doesn\'t have user account!');
		}
		else{
			$this->error('Employee NIP: '.$nip.' not registered!');
		}
    }
}
