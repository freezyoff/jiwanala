<?php 
namespace App\Libraries\Service;

use Illuminate\Database\Eloquent\Model;
use App\Libraries\Foundation\User\RoleOptions;

class Role extends Model{
	protected $table = 'roles';
	protected $connection = 'service';
	
	protected $primaryKey = 'id';
    public $incrementing = false;
	
	protected $fillable = ['creator', 'id','context','display_name','description'];
	
	protected $roleOptions;
	
    public function users(){
		return $this->belongsToMany('\App\Libraries\Service\Auth\User', 'users_roles', 'role_id', 'user_id')->withTimestamps();
	}
	
	public function permissions(){
		return $this->belongsToMany('\App\Libraries\Service\Permission', 'roles_permissions', 'role_id', 'permission_id')->withTimestamps();
	}
}