<?php 
return [
	'titles'=>[
		'landing'=>'Jadwal Kerja',
	],
	'subtitles'=> [
		'landing'=>'Jadwal Kerja Umum',
		'exception'=>'Jadwal Kerja Khusus'
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
		'schedule_default.*.arrival.required_if'=>'Isi Jam Masuk.',
		'schedule_default.*.arrival.date_format'=>'Format tanggal 24 Jam.',
		'schedule_default.*.departure.required_if'=>'Isi Jam Pulang.',
		'schedule_default.*.departure.date_format'=>'Format tanggal 24 Jam.',
		'schedule_exception.*.arrival.required_if'=>'Isi Jam Masuk.',
		'schedule_exception.*.arrival.date_format'=>'Format tanggal 24 Jam.',
		'schedule_exception.*.departure.required_if'=>'Isi Jam Pulang.',
		'schedule_exception.*.departure.date_format'=>'Format tanggal 24 Jam.',
	],
	'info'=>[
		'inputs'=>[
			'1. Jadwal Kerja NIP?',
			'2. Hari dan Waktu Kerja',
		]
	]
];