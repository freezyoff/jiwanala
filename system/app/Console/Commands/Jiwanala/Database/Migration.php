<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Migration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala-db:migrate 
		{migrationDirectories* 	: relative path to "database/migrations"}
		{--con-driver}
		{--con-host}
		{--con-username}
		{--con-password}
		{--con-no-password}
		{--export				: export flag}
		{--export-schema=*		: } 
		{--export-host=			: connection host. default localhost} 
		{--export-username=		: connection username.} 
		{--export-password=		: connection password.}
		{--export-no-password	: connection use no password for given username}
		{--export-driver=		: connection driver}
		{--export-query-limit= 	: query limit. default 1000 records}
		{--export-version= 		: signature time for export key. Use as directoriy in storage/app/database/}
		{--export-mode= 		: SQL or JSON. Default JSON}
		{--import				: import flag}
		{--import-schema=*		: } 
		{--import-host=			: connection host. default localhost} 
		{--import-username=		: connection username} 
		{--import-password=		: connection password}
		{--import-no-password	: connection use no password for given username}
		{--import-driver=		: connection driver}
		{--import-query-limit= 	: query limit. default 1000 records}
		{--import-version= 		: signature time for export key. Refer to directory name in storage/app/database/}
		{--import-mode= 		: SQL or JSON. Default JSON}
		{--import-except=* 		: given schema table will not imported}
		';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Jiwanala Migrations';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function infoRollbackStart(){
		echo "\033[36mStart\033[0m Rolling back Database".PHP_EOL;
	}
	
	function infoRollbackDone(){
		echo "\033[36mDone\033[0m Rolling back Database".PHP_EOL;
	}
	
	function infoRollback($str){
		echo 'Rolling back : '. 
			"\033[33m". $str ."\033".
			"[0m ".PHP_EOL;	
	}
	
	function infoMigrateStart(){
		echo "\033[36mStart\033[0m Migrating Database".PHP_EOL;
	}
	
	function infoMigrateDone(){
		echo "\033[36mDone\033[0m Migrating Database".PHP_EOL;
	}
	
	function infoMigrate($str){
		echo 'Migrating : '. 
			"\033[32m". $str ."\033".
			"[0m ".PHP_EOL;
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // strategy
		// 1. read all files in database/migrations folder
		$files = $this->handleReadFiles();
		//print_r($files);
		
		// 2. rolling back migrations
		$this->line('');
		$this->infoRollbackStart();
		$migrations = \DB::table('migrations')->orderBy('batch','desc')->get();
		$out = "";
		foreach($migrations as $migration){
			$key = $migration->migration.'.php';
			$this->infoRollback(str_replace('.php','', $migration->migration));
				
			\Artisan::call('migrate:rollback',[
				'--step'=>1, 
				'--path'=>$files[$key]->getPathname(),
				'--realpath'=>true,
			]);
		}
		$this->infoRollbackDone();
		
		// 3. run migration
		$this->line('');
		$this->infoMigrateStart();
		$sortedKeys = array_sort( array_keys($files) );
		foreach($sortedKeys as $key){
			$this->infoMigrate(str_replace('.php', '', $key));
				
			\Artisan::call('migrate',[
				'--path'=>$files[$key]->getPathname(),
				'--realpath'=>true,
			]);
		}
		$this->infoMigrateDone();
		
		// 4. Export latest version
		if ($this->option('export')){
			$this->handleExport();
		}
		
		// 5.import lates version if exists
		if ($this->option('import')){
			$this->handleImport();
		}
    }
	
	function handleReadFiles(){
		$list = [];
		foreach($this->argument('migrationDirectories') as $dir){
			foreach(\File::allFiles(database_path('migrations/'.$dir)) as $file){
				$file->connection = $dir;
				$list[$file->getFilename()] = $file;
			}
		}
		return $list;
	}
	
	function handleImport(){
		$options = [
			'import-host'=>			'--con-host',
			'import-username'=>		'--con-username',
			'import-password'=>		'--con-password',		
			'import-no-password'=>	'--con-no-password',
			'import-driver'=>		'--con-driver',		
			'import-query-limit'=>	'--con-query-limit',
			'import-version'=>		'--import-version',		
			'import-mode'=>			'--import-mode',
			'import-except'=>		'--except'
		];
		
		$setOptions = [];
		foreach($options as $key=>$trans){
			if ($this->option($key)){
				$setOptions[$trans] = $this->option($key);
			}
		}
		$setOptions['schema'] = $this->option('import-schema');
		\Artisan::call('jiwanala-db:import', $setOptions, $this->getOutput());
	}
	
	function handleExport(){
		$options = [
			'export-host'=>			'--con-host',
			'export-username'=>		'--con-username',
			'export-password'=>		'--con-password',		
			'export-no-password'=>	'--con-no-password',
			'export-driver'=>		'--con-driver',		
			'export-query-limit'=>	'--con-query-limit',
			'export-mode'=>			'--export-mode',
			'export-version'=>		'--export-version',		
		];
		
		$setOptions = [];
		foreach($options as $key=>$trans){
			if ($this->option($key)){
				$setOptions[$trans] = $this->option($key);
			}
		}
		$setOptions['schema'] = $this->option('export-schema');
		\Artisan::call('jiwanala-db:export', $setOptions, $this->getOutput());
	}
}
