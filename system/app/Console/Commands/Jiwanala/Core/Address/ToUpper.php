<?php

namespace App\Console\Commands\Jiwanala\Core\Address;

use Illuminate\Console\Command;
use App\Libraries\Core\Address;

class ToUpper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-address:toUpper {--remote} {--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make record in database core.addresses upper case';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
	
	function isRemote(){
		return $this->option('remote')? true : false;
	}
	
	function remoteConnection($connectionKey, $database){
		config(['database.connections.'.$connectionKey => [
			'driver' => 	env('DB_REMOTE_DRIVER'),
			'host' => 		env('DB_REMOTE_HOST'),
			'username' => 	env('DB_REMOTE_USERNAME'),
			'password' => 	env('DB_REMOTE_PASSWORD'),
			'database' => 	$database,
		]]);
		
		return $connectionKey;
	}
	
	function getAddresses(){
		return $this->isRemote()?
			Address::on($this->remoteConnection('_remoteAddress','jiwanala_core'))->get() : 
			Address::all();
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		if ($this->isDaemon()){
			$this->line('');
			$this->line('execute on: '.now()->format('Y-m-d H:i:s'));
		}
		
		$remote = $this->isRemote()? 'Remote Database' : 'Local Database';
		$this->line(
			$this->isDaemon()?
			'Start change '.$remote.' jiwanala_core.addresses to upper case.' :
			'<fg=cyan>Start change</> '.$remote.' <fg=green>jiwanala_core</>.<fg=yellow>addresses</> to upper case.'
		);
		
		$count = 0;
		
		$cols = ['address','neighbourhood','hamlet','urban','sub_disctrict','district','province','post_code'];
        foreach($this->getAddresses() as $record){
			$count++;
			foreach($cols as $col){
				$record->{$col}	= preg_replace('/\s+/', ' ', strtoupper($record->{$col}));
			}
			$record->save();
		}
		
		$this->line(
			$this->isDaemon()?
			'Done change '.$count.' records to upper case.' : 
			'<fg=cyan>Done change</> '.$count.' records to upper case.'
		);
    }
	
	function isDaemon(){
		return $this->option('daemon');
	}
}
