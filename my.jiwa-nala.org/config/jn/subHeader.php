<?php return [
	'dashboard'=>[
		'breadcrumb'=>['type'=>'home', 'routeAction'=>'dashboard'],
		'caption'=>'Dashboard',
	],
	
	'bauk'=>[
		'breadcrumb'=>['type'=>'home', 'routeAction'=>'bauk'],
		'caption'=> 'Dashboard (Adm. Umum & Kepegawaian)',
		
		// bauk.mnjkaryawan
		'mnjkaryawan'=> [
			'breadcrumb'=>['type'=>'item', 'routeAction'=>'bauk.mnjkaryawan'],
			'caption'=> 'Daftar Karyawan',
			'quickAction'=>['type'=>'default','view'=>''],
			
			// bauk.mnjkaryawan.add
			'tambah'=>[
				'breadcrumb'=>['type'=>'item', 'routeAction'=>'bauk.mnjkaryawan'],
				'caption'=> 'Tambah Data Karyawan Baru',
			]
		]
	]
	
];