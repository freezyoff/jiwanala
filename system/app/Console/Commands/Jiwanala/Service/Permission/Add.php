<?php

namespace App\Console\Commands\Jiwanala\Service\Permission;

use Illuminate\Console\Command;
use App\Libraries\Service\Permission;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
	protected $signature = 'jn-permission:add {id} {context} {display_name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add permission';

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
        $permission = Permission::create([
			'id'=>$this->argument('id'),
			'context'=>$this->argument('context'),
			'display_name'=>$this->argument('display_name'),
			'description'=>$this->argument('description')
		]);
		$this->line('<fg=cyan>Add</> Permission Context:<fg=green>'.$permission->context.'</> id:<fg=yellow>'.$permission->id.'</>');
    }
}
