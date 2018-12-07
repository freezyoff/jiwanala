<?php return [
    'default_install' => [
        0 => 'service.grant.permission',
        1 => 'service.revoke.permission',
        2 => 'service.list.permission',
        3 => 'service.post.permission',
        4 => 'service.patch.permission',
        5 => 'service.put.permission',
        6 => 'service.delete.permission',
		
		'bauk.list.employee',
        'bauk.post.employee',
        'bauk.patch.employee',
        'bauk.put.employee',
        'bauk.delete.employee',
    ],
    'list' => [
        'service.grant.permission' => [
            0 => 'service',
            1 => 'Grant Service Feature Permission',
            2 => 'Grant Application Level Permission ke user lain',
        ],
        'service.revoke.permission' => [
            0 => 'service',
            1 => 'Revoke Service Feature Permission',
            2 => 'Revoke Application Level Permission ke user lain',
        ],
        'service.list.permission' => [
            0 => 'service',
            1 => 'List Service Feature Permission',
            2 => '-',
        ],
        'service.post.permission' => [
            0 => 'service',
            1 => 'Post Service Feature Permission',
            2 => '-',
        ],
        'service.patch.permission' => [
            0 => 'service',
            1 => 'Patch Service Feature Permission',
            2 => '-',
        ],
        'service.put.permission' => [
            0 => 'service',
            1 => 'Put Service Feature Permission',
            2 => '-',
        ],
        'service.delete.permission' => [
            0 => 'service',
            1 => 'Delete Service Feature Permission',
            2 => '-',
        ],
        'bauk.list.employee' => ['bauk', 'List all Employees', 'View list of employee records'],
        'bauk.post.employee' => ['bauk', 'Post Employees', 'Create and save Employee records'],
        'bauk.patch.employee' => ['bauk', 'Patch Employees', 'Update Employee records'],
        'bauk.put.employee' => ['bauk', 'Put Employees', 'Update Employee records'],
        'bauk.delete.employee' => ['bauk', 'Delete Employees', 'Delete Employee records'],
		
		'profile.patch.own'	=>	['profile', 'Patch owned Profile record', 'Permission to update owned profile record'],
		'profile.put.own'	=>	['profile', 'Put owned Profile record', 'Permission to store owned profile record'],
		'profile.list.own'	=>	['profile', 'List owned Profile record', 'Permission to List owned profile record'],
    ],
];