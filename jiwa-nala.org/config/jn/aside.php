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
		],
		[
			'type'=>2,
			'caption'=>'Presensi',
			'icon'=>'flaticon-users-1',
			'routeAction'=>'bauk.mnjkaryawan',
		],
	],
	
];