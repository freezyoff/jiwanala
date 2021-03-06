<?php

namespace App\Console\Commands\Jiwanala\Service;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-seed:service  {--remote : target remote database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install predefined service records';

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
		
        $this->call('jn-permission:install', $arg, $this->output);
		$this->line('');
		$this->call('jn-role:install', $arg, $this->output);
		$this->line('');
		$installDefaultUser = $this->choice('Install default user?', ['Yes', 'No'], 0);
		if ($installDefaultUser == 'Yes'){
			$this->call('jn-user:add',[
				 'name'=>'akhmad.musa.hadi',
				 'email'=>'akhmad.musa.hadi@gmail.com',
				 'password'=>'Yousummonme3105'
			], $this->output);
		}
    }
}
