<?php

namespace App\Console\Commands\Service;

use Illuminate\Console\Command;

class JiwanalaUser_changepassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:user-pwd {user} {pwd}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password of user';

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
        $user = \App\Libraries\Service\Auth\User::where('name','=',$this->argument('user'))->first();
		if ($user){
			$user->password = \Hash::make($this->argument('pwd'));
			$user->save();
			$this->info('User: '.$this->argument('user').' password has changed.');
		}
		else{
			$this->info('User: '.$this->argument('user').' not found');
		}
    }
}
