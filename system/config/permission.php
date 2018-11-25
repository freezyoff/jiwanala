<?php return [
	'roles'=>[
		'administrator'=>[
			'display_name'=>'Administrator',
			'description'=>'System Administrator',
		],
		'user'=>[
			'display_name'=>'User',
			'description'=>'User',
		]
	],
	
	'permissions'=>[
		'role.grant'=>['display_name'=> 'Grant Role', 'description'=> '', 'roles'=>['administrator']],
		'role.revoke'=>	['display_name'=> 'Revoke Role', 'description'=> '', 'roles'=>['administrator']],
		'role.list'=> ['display_name'=> 'List Role', 'description'=> '', 'roles'=>['administrator','user']],
		
		'permission.grant'=>['display_name'=> 'Grant Permission', 'description'=> '', 'roles'=> ['administrator']],
		'permission.revoke'=>['display_name'=> 'Revoke Permission',	'description'=> '', 'roles'=>['administrator']],
		'permission.list'=>['display_name'=> 'List Permission',	'description'=> '', 'roles'=>['administrator','user']],
	],
	
	//default user roles
	'default_roles'=>['administrator']
];