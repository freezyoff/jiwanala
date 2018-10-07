<?php return [
	'dashboard'=>[
		'landing'=>[
			'caption'=>'Dashboard',
		]
	],
	
	'bauk'=>[
		'landing'=> [
			'caption'=> 'Dashboard (Adm. Umum & Kepegawaian)',
		],
		'mnjkaryawan'=> [
			'caption'=> 'Daftar Karyawan',
			'breadcrumb'=>[
				['type'=>'separator'],
				['type'=>'item','caption'=>'Adm. Umum & Kepegawaian', 'routeAction'=>'bauk.landing'],
				['type'=>'separator'],
				['type'=>'item','caption'=>'Daftar Karyawan', 'routeAction'=>'bauk.mnjkaryawan']
			],
			'quickAction'=>['type'=>'default','view'=>'']
		]
	]
	
];