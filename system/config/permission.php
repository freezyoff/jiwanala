<?php return [
	//	default user permissions
	//	grant via console jiwanala:install
	'default_install'=>[
		'service.grant.permission',
		'service.revoke.permission',
		'service.list.permission',
		'service.post.permission',
		'service.patch.permission',
		'service.put.permission',
		'service.delete.permission',
	],
	
	'list'=>[
		//	Array list
		//	<key> => [ <context>, <display_name>, <description> ]
		
		'service.grant.permission'=>	['service', 'Grant Service Feature Permission', 'Grant Application Level Permission ke user lain'],
		'service.revoke.permission'=>	['service', 'Revoke Service Feature Permission','Revoke Application Level Permission ke user lain'],
		'service.list.permission'=>		['service', 'List Service Feature Permission',	'-'],
		'service.post.permission'=>		['service', 'Post Service Feature Permission',	'-'],
		'service.patch.permission'=>	['service', 'Patch Service Feature Permission',	'-'],
		'service.put.permission'=>		['service', 'Put Service Feature Permission',	'-'],
		'service.delete.permission'=>	['service', 'Delete Service Feature Permission','-'],
	],
];