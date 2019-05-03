<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use \App\Libraries\Service\Permission;

class ListPermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-permission:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all registered permissions';

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
			collect(Permission::all()
			->map(function($item){
				return collect($item)->only(['id','context','display_name','description']);
			}))
		);
    }
}
