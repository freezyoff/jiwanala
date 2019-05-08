<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:add {id} {context} {display_name} {description}
							{--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Role';

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
	
	function createRole($arg){
		if ($this->isRemote()){
			Role::on($this->remoteConnection('_remoteRole', 'jiwanala_service'))->insert($arg);
		}
		else{
			Role::create($arg);
		}
		
		return $this->getRole($arg['id']);
	}
	
	function getRole($id){
		return $this->isRemote()?
			Role::on($this->remoteConnection('_remoteRole', 'jiwanala_service'))->where('id', $id)->first() : 
			Role::find($id);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $role = $this->createRole([
			'id'=>$this->argument('id'),
			'context'=>$this->argument('context'),
			'display_name'=>$this->argument('display_name'),
			'description'=>$this->argument('description')
		]);
		$this->line('<fg=cyan>Add</> Role Context:<fg=green>'.$role->context.'</> id:<fg=yellow>'.$role->id.'</>');
    }
}
