<?php

namespace App\Console\Commands\File;

use Illuminate\Console\Command;

class RemoveDirectory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:rmdir {dir_path} {--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all files in directories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
	function getDirPath(){
		return $this->argument('dir_path');
	}
	
	protected $printRegex = '/(?=\<)(\<(.*)\>(?=\w)|\<\/\>)/';
	function printInfo($str){
		if ($this->isDaemon()){
			$str = preg_replace($this->printRegex,'',$str);
		}
		$this->line($str);
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->isValidDirectory()){
			$this->printInfo('<bg=red>Given directory path is not a folder</>');
		}
		
		if ($this->isDaemon()){
			$now = now();
			$this->printInfo('Start on: '.$now);
		}
		
		$this->printInfo('<fg=yellow>Start remove</> directory : '.$this->getDirPath());
		foreach($this->getFiles() as $file){
			//continue loop if is directory
			if($file->isDir()) continue;
			
			//remove file
			unlink($file);
		}
		rmdir($this->getDirPath());
		$this->printInfo('<fg=yellow>Done remove</> directory : '.$this->getDirPath());
    }
	
	function isValidDirectory(){
		return is_dir($this->getDirPath());
	}
	
	function getFiles(){
		return new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $this->getDirPath() ) );
	}
}
