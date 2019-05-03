<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use \App\Libraries\Service\Permission;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:delete {id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete registered permission';

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
        foreach($this->argument('id') as $id){
			$permission = Permission::find($id);
			if ($permission){
				$permission->delete();
				$this->line('<fg=red>Delete</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');				
			}
		}
    }
}
