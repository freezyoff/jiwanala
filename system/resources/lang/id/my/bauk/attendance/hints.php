<?php return[
	'table'=>[
		'head'=>[
			'Hari / Tanggal',
			'Kehadiran / Izin'
		],
		'empty'=>'Masukkan NIP dan Periode untuk melihat data.',
	],
	'buttons'=>[
		'upload-file'=>'Unggah Berkas',
		'add-upload-file'=>'Tambah berkas',
		'select-upload-file'=>'Pilih / Unggah berkas',
		'type-upload-file'=>'Ekstensi file PDF, JPG/JPEG. Maksimal 16 Mb',
		'download'=>'Unduh contoh berkas:',
		'import'=>'Impor Data Finger',
		'finger-time'=>'Jam',
	],
	
	'modal'=>[
		'endDate'=>'Sampai Tanggal?',
		'dateformat'=>'Format Tanggal',
		'timeformat'=>'Format Waktu',
	],
	
	'errors'=>[
		'consentType'=>'Pilih salah satu jenis Cuti/Izin',
		'noFileUploaded'=>'Sertakan dan upload dokumen Cuti/Izin',
		'uploadConnectionTimeout'=>'Tidak dapat menghubungi server. Mohon cek koneksi.',
		'uploadFileTooLarge'=>'Besar file melebihi 16 Mb',
		'invalidTableFile'=>'Gunakan format tabel yang sesuai. Unduh contoh format tabel.',
	],
	
	'validations'=>[
		//fingers
		'startTime'=>'Isi Jam Masuk Kerja',
		'endTime'=>'Isi Jam Pulang Kerja',
		
		//consent validation
		'consent_type'=>[
			'required'=>'Pilih salah satu Jenis Cuti/Izin',
			'in'=>'Pilih salah satu Jenis Cuti/Izin',
		],
		'file.required'=>'Upload dokumen Cuti/Izin',
		'file.size'=>'Besar File maksimum 16777215 bytes (16 Mb)',
		'endDate'=>[
			'required'=>'Isi tanggal akhir cuti/izin',
			'date_format'=>'Format tanggal Hari Bulan Tahun',
		],
		
		//upload
		'dateformat_required'=>'Pilih salah satu Format Tanggal',
		'timeformat_required'=>'Pilih salah satu Format Waktu',
		'file_required'=>'Sertakan berkas untuk impor',
		'file_format'=>'Format CSV invalid, periksa baris :line',
		
		//import
		'import'=>[
			'nip.exists'=>'NIP tidak terdaftar',
			'tanggal.date_format'=>'Gunakan format tanggal sesuai pilihan',
			'finger_masuk.date_format'=>'Gunakan format Tanggal sesuai pilihan',
			'finger_keluar_1.date_format'=>'Gunakan format Waktu sesuai pilihan',
			'finger_keluar_2.date_format'=>'Gunakan format Waktu sesuai pilihan',
			'finger_keluar_3.date_format'=>'Gunakan format Waktu sesuai pilihan',
			
			'*.nip.exists'=>'NIP tidak terdaftar',
			'*.tanggal.date_format'=>'Gunakan format tanggal sesuai pilihan',
			'*.finger_masuk.date_format'=>'Gunakan format Tanggal sesuai pilihan',
			'*.finger_keluar_1.date_format'=>'Gunakan format Waktu sesuai pilihan',
			'*.finger_keluar_2.date_format'=>'Gunakan format Waktu sesuai pilihan',
			'*.finger_keluar_3.date_format'=>'Gunakan format Waktu sesuai pilihan',
		],
	],
	
	'selections'=>[
		'dateformat'=>[
			'd-m-Y'=> [
				'Tanggal - Bulan - Tahun',
				now()->format('d-m-Y'),
			],
			'd/m/Y'=> [
				'Tanggal / Bulan / Tahun',
				now()->format('d/m/Y'),
			],
			'd m Y'=> [
				'Tanggal Bulan Tahun',
				now()->format('d m Y'),
			],
		],
		'timeformat'=>[
			'H:i:s'=> [
				'24 Jam ',
				now()->format('H:i:s'),
			],
			'h:i:s A'=> [
				'12 Jam (Ante/Post Meridiem)',
				now()->format('h:i:s A'),
			],
		],
	],
	
	'info'=>[
		'upload'=>[
			['h6'=>'Format Tanggal', 'p'=>'Pilih format Tanggal sesuai data pada berkas upload.'],
			['h6'=>'Format Waktu', 'p'=>'Pilih format Waktu sesuai data pada berkas upload.'],
			[
				'h6'=>'Unggah Berkas', 
				'p'=>'Unggah berkas sesuai format yang telah disediakan. Pastikan format kolom tabel,&nbsp;format tanggal,&nbsp;& format waktu sesuai dengan pilihan.<br>'.
					'Unduh contoh file untuk memudahkan impor data.'
			],
			['h6'=>'Impor Data', 'p'=>'Import data proses 1 arah dan tidak dapat diputar kembali. Data lama akan ditumpuk/diganti dengan data baru dari unggahan berkas. Pastikan data telah sesuai.'],
		],
		'finger'=>[
			['h6'=>'Jam Masuk', 'p'=>'Jam masuk menggunakan format waktu 24 jam [jam]:[menit]:[detik].'],
			['h6'=>'Jam Keluar', 'p'=>'Isi salah satu Jam Keluar sesuai waktu finger. Jam keluar menggunakan format waktu 24 jam [jam]:[menit]:[detik].'],
		]
	],
];