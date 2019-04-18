<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Reinstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:reinstall
							{--remote 				: target remote database to reinstall}
							{--export-first 		: export database records before reinstall}
							{--import				: import latest database records in storage/database. use option --export-first if necessary}
							{--import-remote		: instead import latest database records in storage/database, we export remote database records and import to local database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall & Intall jiwanala database migration';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$opt = [];
		if ($this->option('remote')){
			$opt['--remote'] = true;
		}
		
		//check if need to export first
		if ($this->option('export-first')){
			\Artisan::call('jn-db:export',$opt, $this->output);
		}
		
		//do reinstall
        \Artisan::call('jn-db:uninstall', $opt, $this->output);
        \Artisan::call('jn-db:install', $opt, $this->output);
		
		if ($this->option('import-remote')){
			\Artisan::call('jn-db:export',['--remote'=>true], $this->output);
			\Artisan::call('jn-db:import',$opt, $this->output);
		}
		elseif ($this->option('import')){
			\Artisan::call('jn-db:import',$opt, $this->output);
		}
    }
}
