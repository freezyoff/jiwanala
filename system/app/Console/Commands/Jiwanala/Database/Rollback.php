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
    protected $signature = 'jn-db:uninstall 
							{dir? 		: directory migration files take place} 
							{--step=	: uninstall step}
							{--remote	: uninstall remote database}';

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
		$dirs = array_reverse($this->directories());
        foreach($dirs as $dir){
			if ($this->isRepositoryExists($dir)){
				$con = $this->option('remote')? $this->getRemoteConnection($dir) : $dir;
				$this->infoStart($con);
				$opts = [
					'--database'=> 	$con, 
					'--path'=> 		'database/migrations/'.$dir
				];
				
				if ($this->option('step')){
					$opts['--step'] = $this->option('step');
				}
				
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
		$this->line('<fg=cyan>Start </>Uninstall <fg=yellow>'.$conf['host'].'</>.<fg=green>'.$conf['database'].'</>');
	}
	
	function infoDone($dir){
		$this->line('<fg=cyan>Done </>Uninstall');
	}
}
