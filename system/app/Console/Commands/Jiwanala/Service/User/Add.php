<?php

namespace App\Console\Commands\Jiwanala\Service\User;

use Illuminate\Console\Command;
use App\Libraries\Service\Auth\User;

class Add extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jn-user:add {name} {email} {password} {activated=1}';

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
        $user = User::create([
			'name'=>$this->argument('name'),
			'email'=>$this->argument('email'),
			'password'=>\Hash::make($this->argument('password')),
			'activated'=>$this->argument('activated'),
		]);
		$this->line('User <fg=yellow>'.$user->name.'</> created');
    }
}
