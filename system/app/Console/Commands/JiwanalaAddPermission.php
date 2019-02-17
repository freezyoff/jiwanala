<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JiwanalaAddPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:permission-add
								{key? : Permission key} 
								{context? : Permission context}
								{display_name? : Permission display}
								{description? : Permission description}
								{--default : Add default permission}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Permission record';

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
		$permissions=[];
        if($this->option('default')){
			$permissions = config('permission.list');
		}
		else{
			$key = $this->argument('key')?:$this->ask('Permission key: ');
			$permissions[$key] = [
				$this->argument('context')?:$this->ask('Permission context: '),
				$this->argument('display_name')?:$this->ask('Permission display name:'),
				$this->argument('description')?:$this->ask('Permission description: '),
			];
		}
		
		foreach($permissions as  $key=>$permission){
			$this->comment('Process add Permission: ');
			array_unshift($permission, $key);
			$this->doAdd( array_combine(
				['key','context','display_name','description'],
				$permission
			));
		}
    }
	
	function doAdd(Array $permission){
		$record = new \App\Libraries\Service\Permission($permission);
		$record->save();
		$this->info('Permission key: '. $permission['key']. ' context: '.$permission['context'].' added.');
	}
	
}
