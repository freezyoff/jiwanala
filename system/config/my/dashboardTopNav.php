<?php return[
	/*
	 *	'service'=>[									---> permission key context as group
	 *		'display'=>[ 
	 *			'name'=>'name', 						---> display name string
	 *			'icon'=>'icon code'						---> display icon class, <i class=""></i>
	 *		],
	 *		'href'=>'my.service.landing',				---> action target, will call in 'route(target)'
	 *		'permission_context'=>'service',			---> required permission context.
	 *		'sideNav'=>[								---> side bar item list
	 *			[
	 *				'permission'=>''					---> permission needed to acces this link
	 *				'display'=>[ 				
	 *					'name'=>'Permission', 
	 *					'icon'=>false 
	 *				], 
	 *				'href'=>'',							---> target url on click, not read if a group
	 *				'group'=> boolean					---> flag for group sidebar item. will render with accordion
	 *				'items'=> [							---> the list of group items
	 *					[
	 *						'permission'=>''			---> permission needed to acces this link
	 *						'display'=>[ 				
	 *							'name'=>'Permission', 
	 *							'icon'=>false 
	 *						], 
	 *						'href'=>'',					---> target url on click
	 *					]
	 *				]
	 *			]
	 *		]
	 *	],
	 *
	 */
	
	'my'=>[
		'display'=>[ 'name'=>'Dashboard', 'icon'=>'fas fa-home','class'=>'w3-text-light-green'],
		'href'=>'my.dashboard.landing',
	],
	
	'system'=>[
		'display'=>[ 'name'=>'System', 'icon'=>'fas fa-server'],
		'href'=>'my.system.landing',
		'permission_context'=>'system',
		'sideNav'=>[
			[
				'display'=>[ 'name'=>'Akun', 'icon'=>'fas fa-users'], 
				'href'=>'my.system.user.index',
				'permission'=>'system.user.list']
		]
	],
	
	'bauk'=>[
		'display'=>[ 'name'=>'BAUK', 'icon'=>'fas fa-fingerprint'],
		'href'=>'my.bauk.landing',
		'permission_context'=>'bauk',
		'sideNav'=>[
			[
				'display'=>[ 'name'=>'Hari Libur', 'icon'=>'fas fa-calendar-check fa-fw' ], 
				'permission'=>'bauk.holiday.list',
				'href'=>'my.bauk.holiday.landing',
			],
			[
				'display'=>[ 'name'=>'Manajemen Karyawan', 'icon'=>'fas fa-user-circle' ],
				'permission'=>'',
				'href'=>'my.bauk.employee.landing',
				'group'=> true,
				'items'=> [
					[
						'permission'=>'bauk.list.employee',
						'display'=>[ 				
							'name'=>'Daftar Karyawan', 
							'icon'=>false,
						], 
						'href'=>'my.bauk.employee.landing',
					],
					[
						'permission'=>'bauk.schedule.list',
						'display'=>[ 				
							'name'=>'Jadwal Kerja', 
							'icon'=>false,
							'tag'=>[
								'label'=>"update",
								'color'=>'w3-blue'
							]
						], 
						'href'=>'my.bauk.schedule.landing',
					],
				]
			],
			[
				'display'=>[ 'name'=>'Absensi Kehadiran', 'icon'=>'far fa-eye' ], 
				'permission'=>'bauk.attendance.list',
				'href'=>'my.bauk.attendance.landing',
				'group'=> true,
	 			'items'=> [
					[
						'permission'=>'bauk.attendance.list',
						'display'=>[ 				
							'name'=>'Riwayat', 
							'icon'=>false ,
							'tag'=>[
								'label'=>"update",
								'color'=>'w3-blue'
							]
						], 
						'href'=>'my.bauk.attendance.landing',
					],
					[
						'permission'=>'bauk.attendance.post',
						'display'=>[ 				
							'name'=>'Upload Finger', 
							'icon'=>false,
							'tag'=>[
								'label'=>"update",
								'color'=>'w3-blue'
							]
						], 
						'href'=>'my.bauk.attendance.upload',
					],
					[
						'permission'=>'bauk.attendance.report',
						'display'=>[ 				
							'name'=>'Laporan', 
							'icon'=>false,
							'tag'=>[
								'label'=>"update",
								'color'=>'w3-blue'
							]
						], 
						'href'=>'my.bauk.attendance.report.landing',
					]
				]
			],
		]
	],
	
	'baak'=>[
		'display'=>[ 'name'=>'BAAK', 'icon'=>'fas fa-graduation-cap'],
		'href'=>'',
		'permission_context'=>'baak',
		'sideNav'=>[
			[
				'display'=>[ 'name'=>'Manajemen Siswa', 'icon'=>'fas fa-graduation-cap' ],
				'permission'=>'bauk.list.employee',
				'href'=>'my.bauk.employee',
			]
		]
	],
	
	'baku'=>[
		'display'=>[ 'name'=>'BAKU', 'icon'=>'fas fa-donate'],
		'href'=>'',
		'permission_context'=>'baku',
	],
];