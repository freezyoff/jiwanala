<?php return [
	'validation_messages'=>[
		'nip'=>[
			'required'=>				'Nomor NIP wajib diisi.',
			'digits_between'=> 			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=> 				'Gunakan angka.',
			'unique'=>					'Nomor NIP sudah terdaftar.',
		],
		'nik'=>[
			'required'=>				'Nomor KTP wajib diisi.',
			'digits_between'=> 			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=> 				'Gunakan angka.',		
			'unique'=>					'Nomor KTP sudah terdaftar.',
		],
		'name_front_titles'=>[
			'required'=>				'Nama wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
			'max'=>						'Maksimal 50 karakter.',
		],
		'name_full'=>[
			'required'=>				'Nama wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
			'min'=>						'Minimal 5 sampai 100 karakter.',
			'max'=>						'Minimal 5 sampai 100 karakter.',
		],
		'name_back_titles'=>[
			'required'=>				'Nama wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
			'max'=>						'Maksimal 50 karakter.',
		],
		'birth_place'=>[
			'required'=>				'Kota lahir wajib diisi.',
		],
		'birth_date'=>[
			'required'=>				'Tanggal lahir wajib diisi.',
			'date_format'=>				'Format Tanggal lahir <Tanggal> - <Bulan> - <Tahun>.',
		],
		'address'=>[
			'required'=>				'Alamat wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
		],
		'neighbourhood'=>[
			'required'=>				'RT wajib diisi.',
			'numeric'=>					'Gunakan angka.',
			'digits_between'=>			'Jumlah digit {:min} sampai {:max}.',
		],
		'hamlet'=>[
			'required'=>				'RW wajib diisi.',
			'numeric'=>					'Gunakan angka.',
			'digits_between'=>			'Jumlah digit {:min} sampai {:max}.',
		],
		'urban'=>[
			'required'=>				'Kelurahan wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
		],
		'sub_disctrict'=>[
			'required'=>				'Kecamatan wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
		],
		'district'=>[
			'required'=>				'Kota / Kabupaten wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
		],
		'province'=>[
			'required'=>				'Provinsi wajib diisi.',
			'regex'=>					'Gunakan alpabet.',
		],
		'post_code'=>[
			'required'=>				'Kodepos wajib diisi.',
			'numeric'=>					'Gunakan angka.',
			'digits_between'=>			'Jumlah digit {:min} sampai {:max}.',
		],
		'phone'=>[
			'required'=>				'Nomor Telepon / HP wajib diisi.',
			'digits_between'=>			'Jumlah digit min {:min} sampai {:max}.',
			'numeric'=>					'Gunakan angka.',
			'unique'=>					'Nomor Telepon / HP sudah terdaftar.',
			'starts_with'=>				'Tanpa angka depan nol (0 = +62)',		
		],
		'extension'=>[
			'numeric'=>					'Gunakan angka.',
		],
		'work_time'=>[
			'required'=>				'Pilih salah satu.',
		],
		'registered_at'=>[
			'required'=>				'Tanggal terdaftar wajib diisi.',
			'date_format'=>				'Format Tanggal lahir <Tanggal> - <Bulan> - <Tahun>.',
		],
	],
	'hints'=>[
		'nip'=>'Nomor Induk Pegawai',
		'nik'=>'Nomor Kartu Tanda Penduduk',
		'name_full'=>'Nama Lengkap',
		'name_front_titles'=>'Gelar depan',
		'name_back_titles'=>'Gelar belakang',
		'birth_place'=>'Templat lahir',
		'birth_date'=>'Tanggal lahir',
		'address'=>'Alamat',
		'neighbourhood'=>'RT',
		'hamlet'=>'RW',
		'urban'=>'Kelurahan',
		'sub_district'=>'Kecamatan',
		'district'=>'Kota / Kabupaten',
		'province'=>'Provinsi',
		'post_code'=>'Kode Pos',
		'phone'=>'Nomor Telepon / Handphone',
		'extension'=>'Ekstensi',
		'work_time'=>'Jam Kerja',
		'registered_at'=>'Tanggal terdaftar'
	]
];