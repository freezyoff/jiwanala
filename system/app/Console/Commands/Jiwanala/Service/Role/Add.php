<?php

namespace App\Console\Commands\Jiwanala\Service\Role;

use Illuminate\Console\Command;
use App\Libraries\Service\Role;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-role:add {id} {context} {display_name} {description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Role';

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
        $role = Role::create([
			'id'=>$this->argument('id'),
			'context'=>$this->argument('context'),
			'display_name'=>$this->argument('display_name'),
			'description'=>$this->argument('description')
		]);
		$this->line('<fg=cyan>Add</> Role Context:<fg=green>'.$role->context.'</> id:<fg=yellow>'.$role->id.'</>');
    }
}
