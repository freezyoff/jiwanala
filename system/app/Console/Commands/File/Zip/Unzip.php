<?php

namespace App\Console\Commands\File\Zip;

use Illuminate\Console\Command;

class Unzip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'file:unzip 
							{src		: source zip file path} 
							{dst		: destination path}
							{--daemon	: run on background}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unzip to destination path';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function getSourcePath(){
		return $this->argument('src');
	}
	
	function getDestinationPath(){
		return $this->argument('dst');
	}
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
	protected $printRegex = '/(?=\<)(\<(.*)\>(?=\w)|\<\/\>)/';
	function printInfo($str){
		if ($this->isDaemon()){
			$str = preg_replace($this->printRegex,'',$str);
		}
		$this->line($str);
	}
	
	function isDestinationValid(){
		if (!is_dir($this->getDestinationPath())) return false;
	}
	
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
		if ($this->isDaemon()){
			$now = now();
			$this->printInfo('Start <fg=yellow>Unzip</> on: '.$now);
		}
		
		$this->printInfo('<fg=yellow>Unzip</> to: '.$this->getDestinationPath());
		if (!$this->unzip()){
			$this->printInfo('<bg=red>Cannot unzip file.</>');
		}
		$this->printInfo('Done <fg=yellow>Unzip</> file:'.$this->getSourcePath());
    }
	
	function unzip(){
		$unzip = new \ZipArchive();
		$out = $unzip->open($this->getSourcePath());
		if ($out === TRUE) {
			$unzip->extractTo($this->getDestinationPath());
			$unzip->close();
			return true;
		} else {
			return false;
		}
	}
}
