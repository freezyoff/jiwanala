<?php

namespace App\Console\Commands\File;

use Illuminate\Console\Command;
use \Illuminate\Support\Str;

class SearchText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
protected $signature = 'file:find {text} {replace?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

	protected $exceptPath = [
		'/\.\/vendor\/*/',
		'/\.\/storage\/*/'
	];
	
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function isExceptionPath($path){
		foreach($this->exceptPath as $ex){
			if (preg_match($ex, $path)) return true;
			//else $this->line($ex.' != '.$path);
		}
		return false;
	}
	
	function getFiles(){
		try{
			$files = \File::allFiles('./');
			$result = [];
			foreach($files as $file){
				$file = str_replace('\\','/', $file);
				if (!$this->isExceptionPath($file)){
					$result[] = $file;
				}
			}
			
			return $result;
		}
		catch(\InvalidArgumentException $ex){
			return false;
		}
	}
	
	function findTextPosition($content){
		return strpos($content, $this->argument('text'));
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
		ini_set("memory_limit", "-1");
		set_time_limit(0);
		
		$files = $this->getFiles();
		if (!$files){
			//no file, report error
			$this->error('No File Found');
		}
		
		$this->line('<fg=cyan>Find</> text: <fg=yellow>'.$this->argument('text').'</>');
		$findTextLength = strlen($this->argument('text'));
		$match = collect();
		foreach($files as $file){
			
			//read file content
			$content = \File::get($file);
			
			//find the text in file content
			$found = collect();
			while ( !is_bool($pos = $this->findTextPosition($content)) ){
				$textFound = $this->argument('text');
				
				//before search text
				$before = Str::substr($content, 0, $pos);
				$textBefore = Str::substr($before, -1, strrpos($before, PHP_EOL));
				
				//get the content substring start from latest find position
				$content = Str::substr($content, $pos+$findTextLength);
				
				//find nearest end line
				$endLinePosition = strpos($content, PHP_EOL);
				$textAfter = Str::substr($content, 0, $endLinePosition);
				
				$found->push(['pos'=>$pos, 'txt'=>preg_replace('/\s{2,}/','',$textBefore.$textFound.$textAfter)]);
				
			}
			
			if (!$found->isEmpty()){
				$match->put($file, $found->all());				
			}
			
		}
		
		if (!$match->isEmpty()){
			//$max = $match->values()->max('pos');
			//echo $max;
			$maxDigitPosition = strlen(
				$match->flatMap(function($values){
					return $values;
				})->max('pos')
			);
			
			$inspace = '';
			for($i=0;$i<$maxDigitPosition-2; $i++) $inspace .=' ';
			
			foreach($match as $file=>$info){
				$this->line('Found '.$inspace.'<fg=green>in</> : '.$file);
				
				foreach($info as $value){
					//create space
					$space='';
					for($i=0;$i<$maxDigitPosition-strlen($value['pos']); $i++) $space .= ' ';
					
					//print
					$this->line('      '.$space.'<fg=yellow>'.$value['pos'].'</> : '.$value['txt']);
				}
				$this->line('');
			}
			
		}
		else{
			$this->error('Text not Found');
		}
    }
}
