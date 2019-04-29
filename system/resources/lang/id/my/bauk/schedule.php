<?php 
return [
	'titles'=>[
		'landing'=>'Jadwal Kerja',
	],
	'subtitles'=> [
		'landing'=>'Jadwal Kerja Umum',
		'special'=>'Jadwal Kerja Khusus'
	],
	'modal'=>[
		'searchEmployee'=>[
			'title'=>'Daftar Karyawan',
			'icon'=>'fas fa-user fa-fw'
		]
	],
	'hints'=>[
		'arrivalTime'=>'Jam Masuk',
		'departureTime'=>'Jam Pulang',
		'searchKeywords'=>'Pencarian NIP',
		'nip'=>'NIP',
		'name'=>'Nama',
		'save'=>'Simpan',
		'cancel'=>'Batal'
	],
	'validations'=>[
		'schedule.*.arrival.origin.required_if'=>'Isi Jam Masuk.',
		'schedule.*.arrival.origin.date_format'=>'Format tanggal 24 Jam.',
		'schedule.*.departure.origin.required_if'=>'Isi Jam Pulang.',
		'schedule.*.departure.origin.date_format'=>'Format tanggal 24 Jam.',
	],
	'info'=>[
		'inputs'=>[
			'1. Jadwal Kerja NIP?',
			'2. Hari dan Waktu Kerja',
		]
	]
];