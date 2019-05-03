<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;

class ListUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all user';

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
			['id', 'name','email'], 
			collect(User::all()
				->map(function($item){
					return collect($item)->only(['id','name','email']);
				}))
		);
    }
}
