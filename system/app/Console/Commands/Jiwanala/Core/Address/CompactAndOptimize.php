<?php

namespace App\Console\Commands\Jiwanala\Core\Address;

use Illuminate\Console\Command;
use App\Libraries\Core\Address;

class CompactAndOptimize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-address:optimize {--remote} {--daemon} {--clean} {--toUpper}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean & Optimize index of table jiwanala_core.addresses ';

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
		$config = $this->isRemote()? $this->remoteConnection('_remoteAddress','jiwanala_core') : 'core';
		return \DB::connection($config);
	}
	
	function getTable($table){
		return $this->getConnection()->table($table);
	}
	
	function getAddresses(){
		return $this->getTable('addresses')->orderBy('id');
	}
	
	function getPersonAddresses(){
		return $this->getTable('persons_addresses')->orderBy('person_id');
	}
	
	function truncateTables($table){
		$db = $this->getConnection();
		$db->beginTransaction();
		$db->unprepared('SET FOREIGN_KEY_CHECKS=0;');
		$db->unprepared('TRUNCATE TABLE `jiwanala_core`.`'.$table.'`;');
		$db->unprepared('SET FOREIGN_KEY_CHECKS=1;');
		$db->commit();
	}
	
	function mapAddresses(){
		$ADDRESSES = [];
		
		$this->getAddresses()->chunk(100, function($addresses) use($ADDRESSES){
			$idCounter = 1;
			foreach($addresses as $rec){
				$index = $rec->id;
				$rec->id = $idCounter++;
				$ADDRESSES[$index] = $rec;
			}
		});
		
		return $ADDRESSES;
	}
	
	function mapPersonsAddresses(){
		$PERSON_ADDRESSES = [];
		$this->getPersonAddresses()->chunk(100, function($chunks) use($PERSON_ADDRESSES){
			foreach($chunks as $rec){
				$PERSON_ADDRESSES[$rec->person_id][$rec->address_id] = $rec;
			}
		});
		
		return $PERSON_ADDRESSES;
	}
	
	function insertAddresses($data){
		$this->getTable('addresses')->insert($data);
	}
	
	function insertPersonsAddresses($data){
		$this->getTable('persons_addresses')->insert($data);
	}
	
	function isDaemon(){
		return $this->option('daemon');
	}
	
	function isClean(){
		return $this->option('clean');
	}
	
	function isToUpper(){
		return $this->option('toUpper');
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		//cleaning
		$this->line('');
		$this->call('jn-address:clean', [
			'--daemon'=>$this->isDaemon(),
			'--remote'=>$this->isRemote(),
		]);
		
		//to upper
		$this->line('');
		$this->call('jn-address:toUpper', [
			'--daemon'=>$this->isDaemon(),
			'--remote'=>$this->isRemote(),
		]);
		
		$this->line('');
		$this->optimize();
    }
	
	function optimize(){
		if ($this->isDaemon()){
			$this->line('');
			$this->line('execute on: '.now()->format('Y-m-d H:i:s'));
		}
		
		//map tables
        $ADDRESSES = 		$this->mapAddresses();
		$PERSON_ADDRESSES = $this->mapPersonsAddresses();
		
		//truncate table persons_addresses
		$this->truncateTables('persons_addresses');
		//truncate table address`
		$this->truncateTables('addresses');
		
		//start insert 
		$db = $this->getConnection();
		$db->beginTransaction();
		$db->statement('SET FOREIGN_KEY_CHECKS=0');
		foreach($ADDRESSES as $old=>$rec){
			$db->table('jiwanala_core.addresses')->insert((array)$rec);
		}
		$db->statement('SET FOREIGN_KEY_CHECKS=1');
		$db->commit();
		
		$wrong = [];
		
		$db = $this->getConnection();
		$db->beginTransaction();
		$db->statement('SET FOREIGN_KEY_CHECKS=0');
		foreach($PERSON_ADDRESSES as $personID=>$addresses){
			foreach(array_keys($addresses) as $addressID){
				
				//$ADDRESSES[$addressID] not found, we continue
				if (!isset($ADDRESSES[$addressID])) {
					$wrong[] = [$personID, $addressID];
					continue;
				}
					
				$PERSON_ADDRESSES[$personID][$addressID]->address_id = $ADDRESSES[$addressID]->id;
					
				$db->table('jiwanala_core.persons_addresses')->insert( 
					(array) $PERSON_ADDRESSES[$personID][$addressID] 
				);
					
			}
		}
		$db->statement('SET FOREIGN_KEY_CHECKS=1');
		$db->commit();
		
		foreach($wrong as $id){
			if ($this->isDaemon()){
				$this->line('Wrong Link Person id: '.$id[0].'  Address id: '.$id[1].' ignored!');				
			}
			else{
				$this->line('<fg=red>Wrong Link</> Person id: '.$id[0].'  Address id: '.$id[1].' ignored!');				
			}
		}
		
		if (count($wrong)<=0){
			$this->line(
				$this->isDaemon()?
				'Cleaned and Optimized' :
				'<fg=cyan>Cleaned and Optimized</>' 
			);
		}
	}
	
}