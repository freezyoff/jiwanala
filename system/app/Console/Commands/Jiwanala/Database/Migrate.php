<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Migrate extends Command
{
	
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:install 
							{dir?		: directory where migration files take place}
							{--step=	: installation step}
							{--remote	: use remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate all jiwanala database';

	protected $directoris = ['service','core','bauk', 'baak', 'baku'];
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach($this->directories() as $dir){
			$con = $this->option('remote')? $this->getRemoteConnection($dir) : $dir;
			$this->infoStart($con);
			$opts = [
				'--database'=> 	$con,
				'--path'=> 		'database/migrations/'.$dir
			];
			
			if ($this->option('step')){
				$opts['--step'] = $this->option('step');
			}
				
			\Artisan::call('migrate', $opts, $this->output);
			$this->infoDone($con);
		}
    }
	
	function directories(){
		return $this->argument('dir')? [$this->argument('dir')] : $this->directories;
	}
	
	function getRemoteConnection($dir){
		$conf = config('database.connections.'.$dir);
		
		$remoteConf = [];
		foreach($conf as $key=>$item){
			if ($key == 'driver') $remoteConf[$key] = env('DB_REMOTE_DRIVER');
			elseif ($key == 'host') $remoteConf[$key] = env('DB_REMOTE_HOST');
			elseif ($key == 'username') $remoteConf[$key] = env('DB_REMOTE_USERNAME');
			elseif ($key == 'password') $remoteConf[$key] = env('DB_REMOTE_PASSWORD');
			else $remoteConf[$key] = $item;
		}
		
		
		$key = 'remote_'.$dir;
		config(['database.connections.'.$key => $remoteConf]);
		return $key;
	}
	
	function infoStart($dir){
		$conf = config('database.connections.'.$dir);
		echo "\033[36mStart \033".
			"[0mInstall Database at: \033[33m".$conf['host']." \033[0m".
			"schema: \033[36m".$conf['database']."\033[0m".PHP_EOL;
	}
	
	function infoDone($dir){
		$conf = config('database.connections.'.$dir);
		echo "\033[36mDone \033".
			"[0mInstall Database at: \033[33m".$conf['host']." \033[0m".
			"schema: \033[36m".$conf['database']."\033[0m".PHP_EOL . PHP_EOL;
	}
}
