<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestScript extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $permission = \App\DBModels\JNCore\PermissionModel::find(1);
		$permission->roles()->attach(\App\DBModels\JNCore\RoleModel::find(1));
    }
}