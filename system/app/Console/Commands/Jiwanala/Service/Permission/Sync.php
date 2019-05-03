<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use App\Libraries\Service\Permission;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permission records in database. Install new Permission if available';

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
			$permission = Permission::firstOrNew(['id'=>$key],$arg);
			
			$saved=$permission->exists;
			$this->line('<fg=cyan>'.($saved? 'Sync':'Add ').'</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');
		}
    }
}
