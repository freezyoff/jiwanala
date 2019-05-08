<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:install {--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install predefined Roles and its permissions';

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
		
        $this->call('jn-role:sync', $arg, $this->output);
    }
}
