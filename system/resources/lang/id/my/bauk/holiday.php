<?php return[
	'title'=>'Hari Libur',
	'subtitles'=>[
		'landing'=>'Daftar Hari Libur',
		'add'=>'Even Hari Libur'
	],
	
	'hints'=>[
		'name'=>'Event hari libur?',
		'start'=>'Mulai tanggal?',
		'end'=>'Sampai tanggal?',
		'repeat'=>'Setiap tahun atau tahun ini saja?',
		'save'=>'Simpan',
		'back'=>'Batal',
		'delete'=>'Hapus',
		'add'=>'Tambah Hari Libur',
	],
	
	'validation'=>[
		'messages'=>[
			'name.required' => 'Mohon isi :attribute.',
			'name.min' => ':attribute minimal 4 karakter',
			'repeat.required' => 'Pilih salah satu :attribute.',
			'repeat.in' => 'Pilih salah satu tipe :attribute.',
			'start.required' => 'Isi :attribute.',
			'start.date_format' => 'Format tanggal :attribute (hari)-(bulan)-(tahun)',
			'start.overlap' => ':attribute overlap dengan hari libur :eventname',
			'end.required' => 'Isi :attribute.',
			'end.date_format' => 'Format tanggal :attribute (hari)-(bulan)-(tahun)',
			'end.overlap' => ':attribute overlap dengan hari libur :eventname',
		],
		'attributes'=>[
			'name' => 'Nama Hari Libur',
            'start' => 'Tanggal Mulai Libur',
            'end' => 'Tanggal Akhir Libur',
			'repeat' => 'Pengulangan hari libur',
		]
	],
	
	'info'=>[
		['h6'=>'Nama Hari libur', 'p'=>'Gunakan istilah umum hari libur dan gunakan huruf dan angka jika perlu.'],
		['h6'=>'Tanggal Mulai Libur & Tanggal Selesai Libur', 'p'=>'Pastikan tidak tumpang tindih dengan hari libur yang lain.<br> Gunakan format tanggal [Tanggal]-[Bulan]-[Tahun].'],
		['h6'=>'Pengulangan Hari Libur', 'p'=>'Pilih pengulangan setiap tahun jika hari libur jatuh pada tanggal dan bulan yang sama setiap tahunnya. Pilih pengulangan tahun ini saja jika hari libur tidak jatuh pada tanggal dan bulan yang sama untuk tiap tahunnya.'],
	],
	
	'table'=>[
		'empty'=>'Belum ada hari libur.'
	]
];