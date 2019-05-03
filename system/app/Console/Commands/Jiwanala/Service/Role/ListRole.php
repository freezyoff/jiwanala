<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class ListRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all Roles';

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
        $this->table(
			['ID','Context', 'Display Name', 'Descriptions'], 
			collect(Role::all()
				->map(function($item){
					return collect($item)->only(['id','context','display_name','description']);
				}))
		);
    }
}
