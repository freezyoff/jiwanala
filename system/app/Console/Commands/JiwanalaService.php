<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class JiwanalaService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:service
							{--M|migrate : Migrate all table in schema jn_service to support Service Feature}
							{--R|rollback : Rollback table in schema jn_service to support Service Feature}
							{--S|serve : Rollback & Migrate all table, and install default data in schema jn_service to support Service Feaure}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Service Feature installation for domain service.jiwa-nala.org';

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
		if (!$this->option('serve') && !$this->option('migrate') &&
			!$this->option('rollback')){
			$this->error('                           ');
			$this->error('Use one of options:        ');
			$this->error('      -M | --migrate       ');
			$this->error('      -S | --rollback      ');
			$this->error('      -S | --serve         ');
			$this->error('                           ');
			return;
		}
		
		//{--S|serve : Rollback & Migrate all table, and install default data in schema jn_service to support Service Feaure}';
		//{--R|rollback : Rollback table in schema jn_service to support Service Feature}
		if ($this->option('serve') || $this->option('rollback')){
			$this->line('Rollingback tables:');
			$this->runMigration([
				'/database/migrations/service/permission',
				'/database/migrations/service/user',
				'/database/migrations/service/system',
			], true);
		}
		
		//{--S|serve : Rollback & Migrate all table, and install default data in schema jn_service to support Service Feaure}';
		//{--M|migrate : Migrate table in schema jn_service to support Service Feature}
		if ($this->option('serve') || $this->option('migrate')){
			$this->line('Creating tables:');
			$this->runMigration([
				'/database/migrations/service/system',
				'/database/migrations/service/user',
				'/database/migrations/service/permission',
			]);
		}
		
		if ($this->option('serve')){
			//add default permission
			$this->line('Add Default Permissions');
			$permissionList = config('permission.list');
			foreach($permissionList as $key=>$item){
				//	{--key=  : key of permission}
				//	{--context= : context of permission}
				//	{--display= : display name of permission}
				//	{--desc= : description of permission}';
				//	extract the data
				$fill = array_combine(['--context','--display','--desc'],$item);
				$fill['--key'] = $key;
				$fill['--add'] = true;
				$fill['--overwrite'] = true;
				$fill['--overwrite'] = true;
				$this->call('jiwanala:service-permission', $fill);
				$this->info( str_replace(['\n','\r'],'',Artisan::output()) );
			}
		
			//add default user
			$this->line('Add Default user');
			$this->call('jiwanala:service-user',['--add'=>true]);
			
			//grant permission
			//get first user
			$user = \App\Libraries\Service\Auth\User::find(1);
			$this->line('Add Default Permission to User: '.$user->name);
			foreach($permissionList as $key=>$perm){
				$this->callSilent('jiwanala:service-user',['--grant'=>$key, '--name'=>$user->name]);
				$this->info('added Permission: '.$key);
			}
		}
	}
	
	function runMigration($migrationPaths, $rollback=false){
		$migrationPaths = is_array($migrationPaths)? $migrationPaths : [$migrationPaths];
		foreach($migrationPaths as $path){
			$command = $rollback? 'migrate:rollback' : 'migrate';
			Artisan::call($command,['--path'=>$path]);
			$this->info(
				str_replace(['\n','\r'],'',Artisan::output())
			);
		}
	}
}