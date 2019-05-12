<?php return[
	/*
	 *	'service'=>[													---> permission key context as group
	 *		'display'=>[ 
	 *			'name'=>'name', 										---> display name string
	 *			'icon'=>'icon code'										---> display icon class, <i class=""></i>
	 *		],
	 *		'href_route'=>'my.service.landing',							---> action target, will call in 'route(target)'
	 *		'filter_role'=>'service',									---> required role context.
	 *		'filter_role_context'=>'service',							---> required permission context.
	 *		'filter_permission'=>'service',								---> required permission context.
	 *		'filter_permission_context'=>'service',						---> required permission context.
	 *		'leftNav'=>[												---> side bar item list
	 *			[
	 *				'filter_permission'=>''									---> permission needed to acces this link
	 *				'display'=>[ 				
	 *					'name'=>'Permission', 
	 *					'icon'=>false 
	 *				], 
	 *				'href_route'=>'',									---> target url on click, not read if a group
	 *				'group'=> boolean									---> flag for group sidebar item. will render with accordion
	 *				'items'=> [											---> the list of group items
	 *					[
	 *						'filter_role'=>'service',					---> required role context.
	 *						'filter_role_context'=>'service',			---> required permission context.
	 *						'filter_permission'=>'service',				---> required permission context.
	 *						'filter_permission_context'=>'service',		---> required permission context.
	 *						'display'=>[ 				
	 *							'name'=>'Permission', 
	 *							'icon'=>false 
	 *						], 
	 *						'href_route'=>'',				---> target url on click
	 *					]
	 *				]
	 *			]
	 *		]
	 *	],
	 *
	 */
	
	'my'=>[
		'display'=>[ 'name'=>'Dashboard', 'icon'=>'fas fa-home','class'=>'w3-text-light-green'],
		'href_route'=>'my.dashboard.landing',
	],
	
	'system'=>[
		'display'=>[ 'name'=>'System', 'icon'=>'fas fa-server'],
		'href_route'=>'my.system.landing',
		'permission_context'=>'system',
		'leftNav'=>[
			[
				'display'=>[ 'name'=>'Akun', 'icon'=>'fas fa-users'], 
				'href_route'=>'my.system.user.index',
				'filter_permission'=>'system.user.list'
			],
			[
				'display'=>[ 'name'=>'Unit / Divisi', 'icon'=>'fas fa-users'], 
				'href_route'=>'my.system.user.index',
				'filter_permission'=>'system.user.list'
			]
		]
	],
	
	'bauk'=>[
		'display'=>[ 'name'=>'BAUK', 'icon'=>'fas fa-fingerprint'],
		'href_route'=>'my.bauk.landing',
		'permission_context'=>'bauk',
		'leftNav'=>[
			[
				'display'=>[ 'name'=>'Hari Libur', 'icon'=>'fas fa-calendar-check fa-fw' ], 
				'filter_permission'=>'bauk.holiday.list',
				'href_route'=>'my.bauk.holiday.landing',
			],
			[
				'display'=>[ 'name'=>'Manajemen Karyawan', 'icon'=>'fas fa-user-circle' ],
				'href_route'=>'my.bauk.employee.landing',
				'group'=> true,
				'items'=> [
					[
						'filter_permission'=>'bauk.employee.list',
						'display'=>[ 				
							'name'=>'Daftar Karyawan', 
							'icon'=>false,
						], 
						'href_route'=>'my.bauk.employee.landing',
					],
					[
						'filter_permission'=>'bauk.assignment.list',
						'display'=>[ 
							'name'=>'Penugasan',
							'tag'=>[
								'label'=>"update",
								'color'=>'w3-blue'
							]
						], 
						'href_route'=>'my.bauk.assignment.landing',
					],
					[
						'filter_permission'=>'bauk.schedule.list',
						'display'=>[ 				
							'name'=>'Jadwal Kerja', 
							'icon'=>false,
							//'tag'=>[
							//	'label'=>"update",
							//	'color'=>'w3-blue'
							//]
						], 
						'href_route'=>'my.bauk.schedule.landing',
					],
				]
			],
			[
				'display'=>[ 'name'=>'Absensi Kehadiran', 'icon'=>'far fa-eye' ], 
				'filter_permission'=>'bauk.attendance.list',
				'href_route'=>'my.bauk.attendance.landing',
				'group'=> true,
	 			'items'=> [
					[
						'filter_permission'=>'bauk.attendance.list',
						'display'=>[ 				
							'name'=>'Riwayat', 
							'icon'=>false ,
							//'tag'=>[
							//	'label'=>"new feature",
							//	'color'=>'w3-green'
							//]
						], 
						'href_route'=>'my.bauk.attendance.landing',
					],
					[
						'filter_permission'=>'bauk.attendance.post',
						'display'=>[ 				
							'name'=>'Upload Finger', 
							'icon'=>false,
							//'tag'=>[
							//	'label'=>"update",
							//	'color'=>'w3-blue'
							//]
						], 
						'href_route'=>'my.bauk.attendance.upload',
					],
					[
						'filter_permission'=>'bauk.attendance.report',
						'display'=>[ 				
							'name'=>'Laporan', 
							'icon'=>false,
							//'tag'=>[
							//	'label'=>"new feature",
							//	'color'=>'w3-green'
							//]
						], 
						'href_route'=>'my.bauk.attendance.report.landing',
					]
				]
			],
		]
	],
	
	'baak'=>[
		'display'=>[ 'name'=>'BAAK', 'icon'=>'fas fa-graduation-cap'],
		'href_route'=>'my.baak.landing',
		'permission_context'=>'baak',
		'leftNav'=>[
			[
				'display'=>[ 'name'=>'Siswa', 'icon'=>'fas fa-graduation-cap' ],
				'filter_permission'=>'baak.student.list',
				'group'=> true,
				'items'=>[
					[
						'display'=>[ 				
							'name'=>'Daftar Siswa', 
							'icon'=>false ,
							//'tag'=>[
							//	'label'=>"new feature",
							//	'color'=>'w3-green'
							//]
						], 
						'href_route'=>'my.baak.student.landing',
						'filter_permission'=>'baak.student.list',
					]
				]
			]
		]
	],
	
	/*
	'head-master'=>[
		'display'=>['name'=>'Kepala Sekolah', 'icon'=>''],
		'href_route'=>'my.head-master.landing',
		'permission_context'=>function(){
			
		},
	],
	
	'baku'=>[
		'display'=>[ 'name'=>'BAKU', 'icon'=>'fas fa-donate'],
		'href_route'=>'',
		'permission_context'=>'baku',
	],
	*/
];