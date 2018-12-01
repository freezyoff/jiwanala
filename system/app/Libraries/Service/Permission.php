<?php 
namespace App\Libraries\Service;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model{
	protected $table = 'permissions';
	protected $connection = 'service';
	protected $fillable = ['creator', 'key','context','display_name','decription'];
	
    public function users(){
		return $this->belongsToMany('\App\Libraries\Service\Auth\User', 'users_permissions', 'permission_id', 'user_id')->withTimestamps();
	}
}