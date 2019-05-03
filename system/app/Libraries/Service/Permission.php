<?php 
namespace App\Libraries\Service;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
	protected $table = 'permissions';
	protected $connection = 'service';
	
	protected $primaryKey = 'id';
    public $incrementing = false;
	
	protected $fillable = ['creator', 'id','context','display_name','description'];
	
    public function roles(){
		return $this->belongsToMany('\App\Libraries\Service\Role', 'roles_permissions', 'permission_id', 'role_id')->withTimestamps();
	}
}