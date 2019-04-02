<?php return [
    'default_install' => [
        'service.grant.permission',
        'service.revoke.permission',
        'service.list.permission',
        'service.post.permission',
        'service.patch.permission',
        'service.put.permission',
        'service.delete.permission',
    ],
    'list' => [
		'profile.patch.own'	=>	['profile', 'Patch owned Profile record', 'Permission to update owned profile record'],
		'profile.put.own'	=>	['profile', 'Put owned Profile record', 'Permission to store owned profile record'],
		'profile.list.own'	=>	['profile', 'List owned Profile record', 'Permission to List owned profile record'],
		
		/*
		 *	Domain: Service
		 */
		'service.grant.permission' => ['service', 'Grant Service Feature Permission', 'Grant Application Level Permission ke user lain'],
        'service.revoke.permission' => ['service', 'Revoke Service Feature Permission', 'Revoke Application Level Permission ke user lain'],
        'service.list.permission' => ['service', 'List Service Feature Permission', '-'],
        'service.post.permission' => ['service', 'Post Service Feature Permission', '-'],
        'service.patch.permission' => ['service', 'Patch Service Feature Permission', '-'],
        'service.put.permission' => ['service', 'Put Service Feature Permission', '-'],
        'service.delete.permission' => ['service', 'Delete Service Feature Permission', '-'],
		
		/*
		 *	Domain: My - System
		 */
		'system.user.list' => ['system', 'List user', 'List registered user'],
		'system.user.post' => ['system', 'List user', 'List registered user'],
		'system.user.patch' => ['system', 'List user', 'List registered user'],
		'system.user.delete' => ['system', 'List user', 'List registered user'],
		'system.division.list'=>['corp','List Corporate division', 'Melihat daftar unit/divisi'],
		'system.division.post'=>['corp','Post Corporate division', 'Menambah daftar unit/divisi'],
		'system.division.patch'=>['corp','Patch Corporate division', 'Merubah daftar unit/divisi'],
		'system.division.delete'=>['corp','Delete Corporate division', 'Menghapus daftar unit/divisi'],
		
		/*
		 *	Domain: My - BAUK
		 */
		 
		//employee
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
        'bauk.attendance.report' => ['bauk', 'Generate Report', 'Menyusun laporan kehadiran'],
		
		//holiday
		'bauk.holiday.list'=>['bauk', 'List Holiday', 'Melihat daftar hari libur'],
		'bauk.holiday.post'=>['bauk', 'Post Holiday', 'Menambahkan hari libur'],
		'bauk.holiday.patch'=>['bauk', 'Patch Holiday', 'Merubah data hari libur'],
		'bauk.holiday.delete'=>['bauk', 'Delete Holiday', 'Menghapus data hari libur'],
		
		//schedule
		'bauk.schedule.list'=>['bauk', 'List Employee Schedule', 'Melihat daftar jadwal kerja'],
		'bauk.schedule.post'=>['bauk', 'Post Employee Schedule', 'Menambah jadwal kerja'],
		'bauk.schedule.patch'=>['bauk', 'Patch Employee Schedule', 'Merubah jadwal kerja'],
		'bauk.schedule.delete'=>['bauk', 'Delete Employee Schedule', 'Menghapus jadwal kerja'],
		
		//assignment
		'bauk.assignment.list'=>['bauk', 'List Employee Assignment', 'Melihat daftar penugasan karyawan'],
		'bauk.assignment.assign'=>['bauk', 'Give Employee Assignment', 'Memberikan penugasan karyawan'],
		'bauk.assignment.release'=>['bauk', 'Release Employee Assignment', 'Mencabut penugasan karyawan'],
    ],
];