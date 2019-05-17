<?php return[
	'student'=>'Siswa',
	'personal'=>'Pribadi',
	'father'=>'Ayah',
	'mother'=>'Ibu',
	'guardian'=>'Wali',
	
	'title'=>'Tambah Data Siswa',
	'subtitle'=>'Data Siswa',
	
	'hints'=>[
		'personal_data'=>'Data Pribadi',
		'father_data'=>'Data Ayah',
		'mother_data'=>'Data Ibu',
		'guardian_data'=>'Data Wali',
		'id_data'=>'Data Induk',
		'name'=>'Nama :attr',
		'kk'=>'Nomor Kartu Keluarga',
		'nik'=>'Nomor Induk Kependudukan',
		'nis'=>'Nomor Induk Siswa',
		'nisn'=>'Nomor Induk Siswa Nasional',
		'register_type'=>'Terdaftar Sebagai',
		'register_at'=>'Tanggal terdaftar',
		'email'=>'Alamat Email',
		'birth_place'=>'Kota Lahir',
		'birth_date'=>'Tanggal Lahir',
		'gender'=>'Gender',
		'phone'=>'Nomor Telepon',
		'address'=>'Alamat Tinggal',
		'work_address'=>'Alamat Kantor',
		'neighbourhood'=>'RT',
		'hamlet'=>'RW',
		'urban'=>'Keluarahan',
		'subdistrict'=>'Kecamatan',
		'district'=>'Kota',
		'province'=>'Provinsi',
		'postcode'=>'Kode Pos',
	],
	
	'select'=>[
		'property_association'=>[
			'ft'=>'Gunakan :property Ayah',
			'mt'=>'Gunakan :property Ibu',
			'gu'=>'Gunakan :property Wali',
		],
		'register_types'=>[
			'nw'=>'Siswa Baru',
			'tr'=>'Siswa Transfer'
		]
	],
	
	'validations'=>[
		'student'=>[
			'nis'=>[
				'required'=>			'Mohon isi Nomor Induk Siswa.',	
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 20 karakter angka.',
				'exists'=>				'Nomor NIS sudah terdaftar.',
				'Unique'=>				'Nomor NIS sudah terdaftar.',
			],
			'nisn'=>[
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 30 karakter angka.',	
			],
			'register_type'=>[
				'required'=>			'Mohon pilih Jenis Pendaftaran Siswa.',			
				'in'=>					'Pilih yang tersedia.',
			],
			'register_at'=>[
				'required'=>			'Mohon isi Tanggal Terdaftar.',
				'date_format'=>			'Gunakan format tanggal [tanggal:2dg]-[bulan:2dg]-[tahun:4dg].',
			],
			'kk'=>[
				'required'=>			'Mohon isi Nomor Kartu Keluarga.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 30 karakter angka.',
			],
			'nik'=>[
				'required'=>			'Mohon isi Nomor Induk Kependudukan.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 30 karakter angka.',			
			],
			'name_full'=>[
				'required'=>			'Mohon isi Nama Siswa.',
				'regex'=>				'Gunakan karakter huruf.',			
			],
			'gender'=>[
				'required'=>			'Mohon pilih Gender.',
				'in'=>					'Pilih yang tersedia.',			
			],
			'birth_place'=>[
				'required'=>			'Mohon isi Tempat Lahir',			
				'regex'=>				'Gunakan karakter huruf.',
			],
			'birth_date'=>[
				'required'=>			'Mohon isi Tanggal Lahir.',
				'date_format'=>			'Gunakan format tanggal [tanggal:2dg]-[bulan:2dg]-[tahun:4dg].',
			],
			'email'=>[
				[
					'required'=> 		'Mohon isi Alamat Email',
					'email'=> 			'Gunakan format email yang benar.',
				],
				[
					'required_without'=>'Mohon isi Alamat Email.',
					'email'=> 			'Gunakan format email yang benar.',				
				]
			],
			'address'=>[
				'required'=>			'Mohon pilih Alamat Tinggal Siswa.',			
				'in'=>					'Pilih yang tersedia.',
			],
		],
		'parent'=>[
			'gender'=>[
				'required'=>			'Mohon pilih Gender.',
				'in'=>					'Pilih yang tersedia.',
			],
			'kk'=>[
				'required'=>			'Mohon isi Nomor Kartu Keluarga.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 30 karakter angka.',
			],
			'nik'=>[
				'required'=>			'Mohon isi Nomor Induk Kependudukan.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 30 karakter angka.',
			],
			'name_full'=>[
				'required'=>			'Mohon isi Nama Siswa.',
				'regex'=>				'Gunakan karakter huruf.',			
			],
			'birth_place'=>[
				'required'=>			'Mohon isi Tempat Lahir',			
				'regex'=>				'Gunakan karakter huruf.',
			],
			'birth_date'=>[
				'required'=>			'Mohon isi Tanggal Lahir.',
				'date_format'=>			'Gunakan format tanggal [tanggal:2dg]-[bulan:2dg]-[tahun:4dg].',
			],
			'address'=>[
				'required'=>			'Mohon isi alamat.',
				'regex'=>				'Gunakan karakter huruf.',
			],
			'neighbourhood'=>[
				'required'=>			'Mohon isi RT.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 3 karakter angka.',
			],
			'hamlet'=>[
				'required'=>			'Mohon isi RW.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 3 karakter angka.',
			],
			'urban'=>[
				'required'=>			'Mohon isi Kelurahan.',
				'regex'=>				'Gunakan karakter huruf.',
			],
			'subdistrict'=>[
				'required'=>			'Mohon isi Kecamatan.',
				'regex'=>				'Gunakan karakter huruf.',
			],
			'district'=>[
				'required'=>			'Mohon isi Kota.',
				'regex'=>				'Gunakan karakter huruf.',
			],
			'province'=>[
				'required'=>			'Mohon isi Provinsi.',
				'regex'=>				'Gunakan karakter huruf.',
			],
			'postcode'=>[
				'required'=>			'Mohon isi Kode Pos.',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 10 karakter angka.',
			],
			'email'=>[
				'required'=> 			'Mohon isi Alamat Email',
				'required_without'=>	'Mohon isi Alamat Email',
				'email'=> 				'Gunakan format email yang benar.',
			],
			'phone'=>[
				'required'=> 			'Mohon isi Nomor Telepon',
				'required_without'=>	'Mohon isi Nomor Telepon',
				'numeric'=>				'Gunakan karakter angka.',
				'digits_between'=>		'Maksimal 20 karakter angka.',
				'unique'=>				'Nomor Telepon sudah digunakan',
				'starts_with'=>			'Tanpa awalan "0" (Nol)',
			]
		]
	],
];