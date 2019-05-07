<?php

namespace App\Console\Commands\Jiwanala\Bauk\Employee;

use Illuminate\Console\Command;
use App\Libraries\Bauk\Employee;

class ResetUserPwd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-employee:resetUserPwd {nip	: employee NIP}
							{--remote	: target remote database}';

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
	
	function isRemote(){
		return $this->option('remote');
	}
	
	function getEmployee($nip){
		return $this->isRemote()?
			Employee::on($this->remoteConnection('_remoteUser'), 'jiwanala_service')->where('nip', $nip)->first() : 
			Employee::findByNIP($nip);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$nip = $this->argument('nip');
        $employee = $this->getEmployee($nip);
		if ($employee){
			$this->call('jn-user:resetPwd', 
				[
					'--remote'=>$this->option('remote'),
					'email'=>$employee->asUser->email
				], 
				$this->output
			);
		}
		else{
			$this->error('Employee NIP: '.$nip.' not registered!');
		}
    }
}
