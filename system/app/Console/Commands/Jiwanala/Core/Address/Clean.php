<?php

namespace App\Console\Commands\Jiwanala\Core\Address;

use Illuminate\Console\Command;

class Clean extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-address:clean {--remote} {--daemon}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean unused address records in database jiwanala_core.address';

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
	
	function getConnection(){
		return $this->isRemote()?
			\DB::connection($this->remoteConnection('_remoteAddress','jiwanala_core')) : 
			\DB::connection('core') ;
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
		
		//select unused
        $notUsed = $this->getConnection()->select("
			SELECT id from `addresses` as b
			WHERE b.id NOT IN (
				SELECT `address_id` FROM `persons_addresses` WHERE 1
			)
		");
		
		$ids = [];
		foreach($notUsed as $item){
			$ids[] = $item->id;
		}
		
		if (count($ids)>0){
			$this->line(
				$this->isDaemon()? 
					'Found unused ids: '.implode(",", $ids) : 
					'<fg=yellow>Found unused ids: </>'.implode(",", $ids)
			);
			$this->line(
				$this->isDaemon()? 
					'Start clean unused '.$remote.' addresses' : 
					'<fg=cyan>Start clean unused</> '.$remote.' addresses'
			);
			
			//delete unused
			$notUsed = $this->getConnection()->select("DELETE FROM `addresses` WHERE id IN (".implode(",", $ids).")");
			
			$this->line('<fg=cyan>Done clean unused</> addresses');			
		}
		else{
			$this->line($this->isDaemon()? 'No unused Address' : '<fg=red>No unused Address</>');
		}
    }
	
	function isDaemon(){
		return $this->option('daemon');
	}
}
