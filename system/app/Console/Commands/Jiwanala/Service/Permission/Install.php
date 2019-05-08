<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:install {--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'install perdefined permission';

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
		return $this->option('remote');
	}

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$arg = [];
		if ($this->isRemote()){
			$arg['--remote'] = true;
		}
		
        $this->call('jn-permission:sync', $arg, $this->output);
    }
}