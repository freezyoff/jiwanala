<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use Hash;

class JiwanalaServiceUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:service-user
							{--A|add : Add User}
							{--O|overwrite : Overwrite User if exist, add new User if not}
							{--R|remove : remove User}
							{--G|grant= : permission key}
							{--name=  : User name}
							{--email= : User email}
							{--password= : User password}
							';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'User Schema of Service Feature installation for domain service.jiwa-nala.org';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(){ parent::__construct(); }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){
		$forceMigrate = false;
		if (!$this->option('add') && !$this->option('overwrite') && 
			!$this->option('remove') && !$this->option('grant')){
			$this->error('                           ');
			$this->error('Use one of options:        ');
			$this->error('      -A | --add           ');
			$this->error('      -O | --overwrite     ');
			$this->error('      -R | --remove        ');
			$this->error('      -G | --grant         ');
			$this->error('                           ');
			return;
		}
		
		//{--A|add : Add User}
		//{--O|overwrite : Overwrite User if exist, add new User if not}
		if ($this->option('add') || $this->option('overwrite')){
			$this->doAdd();
		}
		
		//{--R|remove : remove User}
		if ($this->option('remove')){
			$this->doRemove();
		}
		
		if ($this->option('grant')){
			$this->doGrant();
		}
    }
	
	function doAdd(){
		//{--name=  : User name}
		//{--email= : User email}
		//{--password= : User password}
		
		$name = $this->askName();
		$email = $this->askEmail();
		$password= 	$this->option('password')? $this->option('password') : $this->ask('User Password:');
		
		$record = new \App\Libraries\Service\Auth\User([
			'name'=>$name, 
			'email'=>$email, 
			'password'=>Hash::make($password)
		]);
		$record->save();
		$this->info('Added record User Name: '.$name);
	}
	
	function askName(){
		$name = $this->option('name')? $this->option('name') : $this->ask('User Name:');
		if (!$this->option('overwrite')){
			while(!$this->isUnique('name', $name)){
				$this->error('                                                  ');
				$this->error('    User Name already exist. Choose other name    ');
				$this->error('                                                  ');
				$name = $this->ask('Other User Name:');
			}
		}
		return $name;
	}
	
	function askEmail(){
		$email = $this->option('email')? $this->option('email') : $this->ask('User Email:');
		while(!$this->isUnique('email', $email)){
			$this->error('                                                         ');
			$this->error('    User Email already registered. Choose other email    ');
			$this->error('                                                         ');
			$email = $this->ask('Other User Email:');
		}
		return $email;
	}
	
	function isUnique($key, $value){
		return !$this->isRecordExist($key, $value);
	}
	
	function isRecordExist($key, $value){
		$record = \App\Libraries\Service\Auth\User::where('name','=',$key)->first();
		return $record? true:false;
	}
	
	function doRemove(){
		$name = $this->option('name')? $this->option('name') : $this->ask('User Name:');
		if ($this->isRecordExist('name',$name)) {
			$record = \App\Libraries\Service\Auth\User::where('name','=',$name)->first();
			$record->delete();
			$this->info('Delete record User Name: '.$record->name);
		}
		$this->info('No record Deleted');
	}
	
	function doGrant(){
		$permissionKey = $this->option('grant')? $this->option('grant') : false;
		$permission = \App\Libraries\Service\Permission::where('key','=',$permissionKey)->first();
		while(!$permission){
			$permissionKey = $this->option('grant')? $this->option('grant') : $this->ask('Permission Key to grant:');
			$permission = \App\Libraries\Service\Permission::where('key','=',$permissionKey)->first();
		}
		
		$username = $this->option('name')? $this->option('name') : false;
		$user = \App\Libraries\Service\Auth\User::where('name','=',$username)->first();
		while(!$user){
			$username =	$this->option('name')? $this->option('name') : $this->ask('Grant Permission to username:');
			$user = \App\Libraries\Service\Auth\User::where('name','=',$username)->first();
		}
		
		$user->grantPermissions($permission);
		$this->info('User: '.$user->name.' granted Permission: '.$permission->key);
	}
}
