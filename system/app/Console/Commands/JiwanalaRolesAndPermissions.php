<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class JiwanalaRolesAndPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jiwanala:rbac
							{--L|list : start sync RBAC config with RBAC database}
							{--S|sync : start sync RBAC config with RBAC database}
							{--R|roles-only : sync only Roles}
							{--P|permissions-only : sync only Permissions}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync `access_control` config to database Roles and Permissions';

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
		if ($this->option('sync')){
			$this->sync($this->getConfig('roles'), $this->getConfig('permissions'));			
		}
    }
	
	protected function getConfig($key=null){
		$key = $key? 'access_control.'.$key : 'access_control';
		return config($key);
	}
	
	protected function getRecord($type, $key){
		return $type::where('key','=',$key)->first();
	}
	
	protected function sync($roles, $permissions){
		if (!$this->option('permissions-only')){
			$this->syncRoles($roles);
		}
		
		if (!$this->option('roles-only')){
			$this->syncPermissions($permissions);
		}
	}
	
	protected function syncRoles($roles){
		foreach($roles as $key=>$value){
			$db = $this->getRecord(\App\DBModels\JNCore\RoleModel::class, $key);
			if (!$db) {
				$index = ['key'=>$key];
				$model = new \App\DBModels\JNCore\RoleModel(array_merge($index,$value));
				$model->save();
				$this->info('add Role: id='.$model->id.', key='.$model->key);
			}
			else $this->line('old Role: id='.$db->id.', key='.$db->key);
		}
	}
	
	protected function syncPermissions($permissions){
		/*
		 *	Role that need to sync relation with Permission
		 *
		 *		'Role Key'=> [
		 *			'Permission Key', 
		 *			'Permission Key'
		 *		]
		 *
		 */
		$roleRelationToSync = [];
		
		foreach($permissions as $key=>$permission){
			$db = $this->getRecord(\App\DBModels\JNCore\PermissionModel::class, $key);
			if (!$db){
				$index = ['key'=>$key];
				$model = new \App\DBModels\JNCore\PermissionModel(array_merge($index,$permission));
				$model->save();
				
				$db = $model;
				$this->info('add Permission: id='.$db->id.' key='.$db->key);
			}
			else $this->line('old Permission: id='.$db->id.', key='.$db->key);
			
			//prepare for Roles & Permissions sync
			//if already in collection, merge it
			if (array_key_exists($key, $roleRelationToSync)){
				$roleRelationToSync[$key] = array_merge(
					$roleRelationToSync[$key],
					$db['roles']);
			}
			else{
				$roleRelationToSync[$key] = $db['roles'];
			}
		}
		
		$this->syncRelations($roleRelationToSync);
	}
	
	protected function syncRelations($relations){
		foreach($relations as $roleKey=>$permissionKeys){
			$role = $this->getRecord(\App\DBModels\JNCore\RoleModel::class, $roleKey);
			
			//no role recorded, continue
			if (!$role) continue;	
			
			foreach($permissionKeys as $permissionKey){
				//grantPermissions will check if permission already granted to role
				$role->grantPermissions($permissionKey);
			}
		}
	}
}
