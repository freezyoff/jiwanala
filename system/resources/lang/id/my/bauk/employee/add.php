<?php return [
	'validation_messages'=>[
		'NIP'=>[
			'required'=>				'Nomor NIP wajib diisi.',
			'digits_between'=> 			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=> 				'Isi dengan karater numerik.',
			'unique'=>					'Nomor NIP sudah terdaftar.',		
		],
		'KTP'=>[
			'required'=>				'Nomor KTP wajib diisi.',
			'digits_between'=> 			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=> 				'Isi dengan karater numerik.',		
			'unique'=>					'Nomor KTP sudah terdaftar.',
		],
		'nama_lengkap'=>[
			'required'=>				'Nama wajib diisi.',
			'regex'=>					'Isi dengan karater alpabet.',
			'min'=>						'Panjang minimal 5 sampai 100 karakter.',
			'max'=>						'Panjang minimal 5 sampai 100 karakter.',		
		],
		'tlp1'=>[
			'required'=>				'Nomor Telepon / HP wajib diisi',
			'digits_between'=>			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=>					'Isi dengan karater numerik.',
			'unique'=>					'Nomor Telepon / HP sudah terdaftar.',
			'starts_with'=>				'Tanpa angka depan nol (0 = +62)',		
		]
	],
	'hints'=>[
		'NIP'=>'Nomor Induk Pegawai',
		'KTP'=>'Nomor Kartu Tanda Penduduk',
		'nama_lengkap'=>'Nama Lengkap',
		'tlp1'=>'Nomor Telepon / Handphone',
	]
];