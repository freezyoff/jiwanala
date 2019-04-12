<?php

namespace App\Console\Commands\Jiwanala\Database;

use App\Console\Commands\Jiwanala\Database\Migrate;

class Rollback extends Migrate
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:uninstall {--remote}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'rollback all jiwanala database';

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
    public function handle()
    {
		$dirs = $this->directories();
		sort($dirs);
        foreach($dirs as $dir){
			if ($this->isRepositoryExists($dir)){
				$con = $this->option('remote')? $this->getRemoteConnection($dir) : $dir;
				$this->infoStart($con);
				$opts = [
					'--database'=> 	$con, 
					'--path'=> 		'database/migrations/'.$dir
				];
				\Artisan::call('migrate:rollback', $opts, $this->output);
				$this->infoDone($con);
			}
		}
    }
	
	function isRepositoryExists($dir){
		$con = $this->option('remote')? $this->getRemoteConnection($dir) : $dir;
		return \Schema::connection($con)->hasTable('migrations');
	}
	
	function infoStart($dir){
		$conf = config('database.connections.'.$dir);
		echo "\033[36mStart \033[0m".
			"Uninstall Database at: \033[33m".$conf['host']." \033[0m".
			"schema: \033[36m".$conf['database']."\033[0m".PHP_EOL;
	}
	
	function infoDone($dir){
		$conf = config('database.connections.'.$dir);
		echo "\033[36mDone \033[0m".
			"Uninstall Database at: \033[33m".$conf['host']." \033[0m".
			"schema: \033[36m".$conf['database']."\033[0m".PHP_EOL . PHP_EOL;
	}
}
