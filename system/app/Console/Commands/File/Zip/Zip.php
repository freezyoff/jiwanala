<?php

namespace App\Console\Commands\File\Zip;

use Illuminate\Console\Command;

class Zip extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'file:zip 
							{src			: source directory}
							{dst			: destination zip file path to place}
							{path?			: file relative path inside zip. if not provide, set relative path to root zip}
							{--remove-src	: option remove src file}
							{--daemon		: run in background process}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Zip given files.';

	protected $printRegex = '/(?=\<)(\<(.*)\>(?=\w)|\<\/\>)/';
	
	protected $ZIP;
	
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
	
	function isValidSourcePath(){
		return is_dir( $this->getSourcePath() );
	}
	
	function getSourceFiles(){
		return new \RecursiveIteratorIterator( new \RecursiveDirectoryIterator( $this->getSourcePath() ) );
	}
	
	function getSourceFilesCount(){
		$counter = 0;
		foreach($this->getSourceFiles() as $file) $counter++;
		return $counter;
	}
	
	function getDestinationPath(){
		return $this->argument('dst');
	}
	
	function getZipItemPath(){
		$path = $this->argument('path');
		return $path? $path : '';
	}
	
	function createZIP(){
		if (!$this->ZIP){
			$this->ZIP = new \ZipArchive();			
		}
		return $this->ZIP;
	}
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
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
        if (!$this->isValidSourcePath()){
			$this->printInfo('<bg=red>Source path is not directory.</>');
			exit;
		}
		
		if ($this->isDaemon()){
			$now = now();
			$this->printInfo('Start <fg=yellow>Zip</> on: '.$now);
		}
		else{
			$this->printInfo('Start <fg=yellow>Zip</>');
		}
		
		$this->printInfo('<fg=green>Zip file </> to: '.$this->getDestinationPath());
		$ZIP = $this->createZIP();
		
		//try open zip
		$ZIPOpen = $ZIP->open($this->getDestinationPath(), \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
		if (!$ZIPOpen){
			$this->printInfo('<bg=red>Cannot create zip file.</>');
			exit;
		}
		
		//zip opened
		foreach($this->getSourceFiles() as $file){
			//continue loop if is directory
			if($file->isDir()) continue;
			
			//add to zip file
			$zipPath = [];
			if ($this->getZipItemPath()){
				$zipPath[] = $this->getZipItemPath();
			}
			$zipPath[] = basename($file);
			$ZIP->addFile($file, implode('/',$zipPath));
			$this->printInfo('<fg=green>Adding to zip</> file: '. basename($file));
		}
		$ZIP->close();
		
		if ($this->option('remove-src')){
			$this->printInfo('<fg=red>Removing </> source files.');
			\Artisan::call('file:rmdir',[
				'dir_path'=>$this->getSourcePath(),
				'--daemon'=>$this->isDaemon()
			]);
		}
		
		$this->printInfo('Done <fg=yellow>Zip</> file: '.$this->getDestinationPath());
    }
}
