<?php return [
	'roles'=>[
		'administrator'=>[
			'display_name'=>'Administrator',
			'description'=>'System Administrator',
		],
	],
	
	'permissions'=>[
		'role.grant'=>['display_name'=> 'Grant Role', 'description'=> '', 'role'=>['administrator']],
		'role.revoke'=>	['display_name'=> 'Revoke Role', 'description'=> '', 'role'=>['administrator']],
		'role.list'=> ['display_name'=> 'List Role', 'description'=> '', 'role'=>['administrator']],
		
		'permission.grant'=>['display_name'=> 'Grant Permission', 'description'=> '', 'role'=> ['administrator']],
		'permission.revoke'=>['display_name'=> 'Revoke Permission',	'description'=> '', 'role'=>['administrator']],
		'permission.list'=>['display_name'=> 'List Permission',	'description'=> '', 'role'=>['administrator']],
	],
];