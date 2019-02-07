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
		'profile.patch.own'	=>	['profile', 'Patch owned Profile record', 'Permission to update owned profile record'],
		'profile.put.own'	=>	['profile', 'Put owned Profile record', 'Permission to store owned profile record'],
		'profile.list.own'	=>	['profile', 'List owned Profile record', 'Permission to List owned profile record'],
		
        'service.grant.permission' => ['service', 'Grant Service Feature Permission', 'Grant Application Level Permission ke user lain'],
        'service.revoke.permission' => ['service', 'Revoke Service Feature Permission', 'Revoke Application Level Permission ke user lain'],
        'service.list.permission' => ['service', 'List Service Feature Permission', '-'],
        'service.post.permission' => ['service', 'Post Service Feature Permission', '-'],
        'service.patch.permission' => ['service', 'Patch Service Feature Permission', '-'],
        'service.put.permission' => ['service', 'Put Service Feature Permission', '-'],
        'service.delete.permission' => ['service', 'Delete Service Feature Permission', '-'],
        
		'bauk.list.employee' => ['bauk', 'List all Employees', 'View list of employee records'],
        'bauk.post.employee' => ['bauk', 'Post Employees', 'Create and save Employee records'],
        'bauk.patch.employee' => ['bauk', 'Patch Employees', 'Update Employee records'],
        'bauk.put.employee' => ['bauk', 'Put Employees', 'Update Employee records'],
        'bauk.delete.employee' => ['bauk', 'Delete Employees', 'Delete Employee records'],
		
		//attendance
        'bauk.attendance.list' => ['bauk', 'List Employee attendance', 'Melihat data kehadiran karyawan'],
        'bauk.attendance.post' => ['bauk', 'Post Employee attendance', 'Menambah data kehadiran karyawan'],
        'bauk.attendance.patch' => ['bauk', 'Patch Employee attendance', 'Meng-update data kehadiran karyawan'],
        'bauk.attendance.delete' => ['bauk', 'Delete Employee attendance', 'Menghapus data kehadiran karyawan'],
        'bauk.attendance.lock' => ['bauk', 'Lock Employee attendance', 'Mengunci data kehadiran karyawan untuk persiapan laporan'],
		
		//holiday
		'bauk.holiday.list'=>['bauk', 'List Holiday', 'Melihat daftar hari libur'],
		'bauk.holiday.post'=>['bauk', 'Post Holiday', 'Menambahkan hari libur'],
		'bauk.holiday.patch'=>['bauk', 'Patch Holiday', 'Merubah data hari libur'],
		'bauk.holiday.delete'=>['bauk', 'Delete Holiday', 'Menghapus data hari libur'],
    ],
];