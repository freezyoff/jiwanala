<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class JiwanalaMigration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:migrate {type=fresh : one of this type fresh,rollback or serve}
								{--default : Serve default record}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migration of all jiwanala database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

	protected $migrationPaths=[
		'/database/migrations/service/system',
		'/database/migrations/service/user',
		'/database/migrations/service/permission',
		'/database/migrations/core',
		'/database/migrations/bauk',
		'/database/migrations/baak',
	];
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		$type = $this->argument('type');
		$rollback = strtolower($type)=="rollback";
		$serve = strtolower($type)=="serve";
		$fresh = strtolower($type)=="fresh";
		$forward = strtolower($type)=="forward";
		$default = $this->option('default');
		
        if ($serve || $rollback){
			$this->comment('Rolling back database:');
			$this->runMigration(array_reverse($this->migrationPaths),true);
		}
		
		if ($serve || $fresh || $forward){
			$this->comment('Migrate database:');
			$this->runMigration($this->migrationPaths);
		}
		
		if ($default){
			$this->comment('Add default permissions:');
			Artisan::call('jiwanala:add-permission',['--default'=>true]);
			
			$this->comment('Add default user:');
			$name = $this->ask('Default username: ');
			$this->call('jiwanala:add-user',[
				'name'		=> $name, 
				'email'		=> $this->ask('Default user email: '),
				'password'	=> $this->ask('Default user password: ')
			]);
			
			$this->comment('Grant permission(s) to user: '.$name);
			$this->call( 'jiwanala:grant',[
				'user'=> $name,
				'permissions'=> config('permission.default_install')
			]);
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
