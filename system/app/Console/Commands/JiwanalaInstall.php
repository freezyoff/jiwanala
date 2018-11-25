<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Hash;

class JiwanalaInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:install 
							{--U|username= : Akun (username) Administrator }
							{--E|email= : Email Administrator}
							{--P|password= : Sandi Akun (password username) Administrator}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install JIWANALA Enteprise system';

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
    public function handle(){
		$paths = [
			'/database/migrations/',
			'/database/migrations/jn_core',
		];
		
		//	Prepare Database Tables
		$rolled = $paths;
		$this->line('1. Mencari dan menghapus tabel database lama:');
		$this->rollbackMigration(array_reverse($rolled));
		$this->line('2. Membuat tabel database baru:');
		$this->runMigration($paths);
		
		//	Create Default Role & Permissions
		$this->line('3. Membuat Default Roles & Permissions:');
		$this->createRoleAndPermission();
		
		//	Create Administrator User
		$this->line('');
		$this->line('4. Membuat Akun (user) administrator:');
		$this->createUser();
		
		//
		$this->line('');
		$this->line('Instalasi service.jiwa-nala.org selesai');
		$this->line('=========================================================');
    }
	
	protected function rollbackMigration($migrationPaths){
		foreach($migrationPaths as $path){
			Artisan::call('migrate:rollback',['--path'=>$path]);
			$this->info(
				str_replace(['\n','\r'],'',Artisan::output())
			);
		}
	}
	
	protected function runMigration($migrationPaths){
		foreach($migrationPaths as $path){
			Artisan::call('migrate',['--path'=>$path]);
			$this->info(
				str_replace(['\n','\r'],'',Artisan::output())
			);
		}
	}
	
	protected function createUser(){
		$username = $email = $password = false;
		
		if ($this->option('username')) 	{
			$username = $this->option('username');
			$this->info('username : '.$username);
		}
		else{
			$username = $this->ask('Nama Akun (username): ');
		}
			
		if ($this->option('email')){
			$email = $this->option('email');
			$this->info('email    : '.$email);
		}
		else{
			$email = $this->ask('Email: ');
		}
		
		if ($this->option('password')){
			$password = $this->option('password');
			$this->info('password : *******');
		}
		else{
			$password = $this->ask('Sandi (password): ');
		}
		
		$userModel = new \App\DBModels\JNCore\UserModel;
		$userModel->name = $username;
		$userModel->email = $email;
		$userModel->password = Hash::make( $password );
		$userModel->save();
	}
	
	protected function createRoleAndPermission(){
		$tableCell = [];
		$roleConfig = config('permission.roles');
		foreach($roleConfig as $key=>$item){
			$attr = [
				'key' => $key, 
				'display_name' => $item['display_name'], 
				'description' => $item['description']
			];
			$role = new \App\DBModels\JNCore\RoleModel($attr);
			$role->save();
			$tableCell[] = $attr;
		}
		$this->table( ['Role', 'Role Name', 'Role Desc'], $tableCell);
		
		$tableCell=[];
		$permissionConfig = config('permission.permissions');
		foreach($permissionConfig as $key=>$item){
			$attr=[
				'key' => $key, 
				'display_name' => $item['display_name'], 
				'description' => $item['description']
			];
			$permission = new \App\DBModels\JNCore\PermissionModel($attr);
			$permission->save();
			
			//attach to role
			$role = \App\DBModels\JNCore\RoleModel::where('key','=',$item['role'])->first();
			if ($role){
				$permission->roles()->attach($role);
				array_unshift($attr, $role->key);
			}
			$tableCell[] = $attr;
		}
		
		$this->table( ['Role (parent)', 'Permission', 'Permission Name', 'Desc'], $tableCell);
	}
}