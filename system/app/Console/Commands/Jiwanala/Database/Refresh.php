<?php

namespace App\Console\Commands\Jiwanala\Database;

use Illuminate\Console\Command;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-db:refresh {--seed : call jn-db:import} {--remote : connect to remote database}';

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
		
        \Artisan::call('jn-db:uninstall', $opt, $this->output);
        \Artisan::call('jn-db:install', $opt, $this->output);
		
		if ($this->option('seed')){
			\Artisan::call('jn-db:import',$opt, $this->output);
		}
    }
}
