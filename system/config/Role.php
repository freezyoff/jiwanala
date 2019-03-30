<?php return [
	'bauk-leader'=>[
		'permission-context'=>'bauk'
	],
	
	'bauk-admin'=>[
		'permissions'=>[
			//employee
			'bauk.list.employee',
			'bauk.post.employee',
			'bauk.patch.employee',
			'bauk.put.employee',
			
			//attendance
			'bauk.attendance.list',
			'bauk.attendance.post',
			'bauk.attendance.patch',
			'bauk.attendance.delete',
			'bauk.attendance.report',
			
			//holiday
			'bauk.holiday.list',
			'bauk.holiday.post',
			'bauk.holiday.patch',
			
			//schedule
			'bauk.schedule.list',
			'bauk.schedule.post',
			'bauk.schedule.patch',
		
			//assignment
			'bauk.assignment.list'=>['bauk', 'List Employee Assignment', 'Melihat daftar penugasan karyawan'],
		],
	],
	
];