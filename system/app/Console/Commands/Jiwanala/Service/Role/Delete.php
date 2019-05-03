<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Delete extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:delete {id*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Role for given id';

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
			$role = Role::find($id);
			if ($role){
				$role->delete();
				$this->line('<fg=red>Delete</> Role Context:<fg=green>'.$role->context.'</> id:<fg=yellow>'.$role->id.'</>');				
			}
		}
    }
}
