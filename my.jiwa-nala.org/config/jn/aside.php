<?php return[

	/* --------------------------- */
	/*	Dashboard
	/* --------------------------- */
	'dashboard'=>[],
	
	/* --------------------------- */
	/*	BAUK
	/* --------------------------- */
	'bauk'=>[
		['type'=>1,'caption'=>'Adm. Umum & Kepegawaian'],
		[
			'type'=>2,
			'caption'=>'Daftar Karyawan',
			'icon'=>'flaticon-users-1',
			'routeAction'=>'bauk.mnjkaryawan',
			'breadcrumb'=>[
				['class'=>'m-nav__separator', 'caption'=>'', 'routeAction'=>'dashboard.landing'],
				['class'=>'m-nav__item', 'caption'=>'', 'routeAction'=>'dashboard.landing']
			],
		],
		['type'=>0,
			'label'=>[
				'caption'=>'Presensi',
				'icon'=>'fa fa-archive'
			],
			'items'=>[
				[
					'caption'=>'Hellooo',
					'routeAction'=>''
				]
			]
		],
	],
	
];