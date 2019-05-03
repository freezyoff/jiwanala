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
    protected $signature = 'jn-permission:install';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        foreach(config('permission.permissions') as $key=>$permission){
			$arg = array_combine(['context','display_name','description'], $permission);
			$arg['id'] = $key;
			$this->call('jn-permission:add', $arg, $this->output);
		}
    }
}