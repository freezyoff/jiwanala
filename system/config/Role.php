<?php return [
	'bauk.admin'=>[
		'context'=>'bauk',
		'display_name'=>'Administrasi BAUK',
		'description'=>'Admin yang bertugas input data',
		'permissions'=>[
			//employee
			'bauk.employee.list',
			'bauk.employee.post',
			'bauk.employee.patch',
			'bauk.employee.put',
			'bauk.employee.delete',
			
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
			'bauk.holiday.delete',
			
			//schedule
			'bauk.schedule.list',
			'bauk.schedule.post',
			'bauk.schedule.patch',
			'bauk.schedule.delete',
			
			//assignment
			'bauk.assignment.list',
			'bauk.assignment.assign',
			'bauk.assignment.release',
		]
	],
	'bauk.manager'=>[
		'context'=>'bauk',
		'display_name'=>'Ketua BAUK',
		'description'=>'Ketua BAUK',
		'roles'=>['bauk.admin'],
		'permissions'=>[
			'bauk.employee.approver',
			'bauk.attendance.approver',
			'bauk.holiday.approver',
			'bauk.schedule.approver',
			'bauk.assignment.approver',
		]
	],
	'bauk.vice'=>[
		'context'=>'bauk',
		'display_name'=>'Wakil Ketua BAUK',
		'description'=>'Wakil Ketua BAUK',
		'roles'=>['bauk.admin'],
		'permissions'=>[
			'bauk.employee.verifier',
			'bauk.attendance.verifier',
			'bauk.holiday.verifier',
			'bauk.schedule.verifier',
			'bauk.assignment.verifier',
		]
	], 
	
	'division.manager'=>[
		'context'=>'division',
		'display_name'=>'Ketua Divisi',
		'description'=>'Pimpinan Divisi',
		'permissions'=>[
			'division-manager.subordinates.list'
		]
	]
];