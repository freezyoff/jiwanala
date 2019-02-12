<?php return[
	'tags'=>[
		'upload_success'=>'Impor Sukses',
		'upload_fail'=>'Impor Gagal',
	],
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
		'download'=>'Unduh berkas format tabel:',
		'import'=>'Impor Data Finger',
		'finger-time'=>'Jam',
	],
	
	'modal'=>[
		//finger
		'finger'=>'Jam :attribute',
		
		//upload
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
			'nip.required'=>'Isi NIP',
			'nip.numeric'=>'Isi NIP dengan angka',
			'nip.exists'=>'NIP tidak terdaftar',
			'tanggal.required'=>'Isi Tanggal dengan format: [tgl]/[bln]/[thn]',
			'tanggal.date_format'=>'Gunakan format Tanggal: [tgl]/[bln]/[thn]',
			'finger_masuk.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'finger_masuk.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'finger_keluar_1.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'finger_keluar_1.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'finger_keluar_2.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'finger_keluar_3.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			
			'*.nip.required'=>'Isi NIP',
			'*.nip.numeric'=>'Isi NIP dengan angka',
			'*.nip.exists'=>'NIP tidak terdaftar',
			'*.tanggal.required'=>'Isi Tanggal dengan format: [tgl]/[bln]/[thn]',
			'*.tanggal.date_format'=>'Gunakan format Tanggal: [tgl]/[bln]/[thn]',
			'*.finger_masuk.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_masuk.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_1.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_1.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_2.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_3.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
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
		'upload_step'=>[
			[
				'h4'=>'Pengaturan Sistem Operasi Windows',
				'p1'=>'Berkas impor,&nbsp;dibuat dengan mengkonversi berkas <code>Excel</code> ke ekstensi <code>CSV</code>.&nbsp;Sebelum memulai,&nbsp;pastikan pengaturan windows telah sesuai untuk proses konversi.',
				'p2'=>'Unduh cara pengaturan sistem operasi berikut:'
			],
			[
				'h4'=>'Unduh Berkas Format Tabel',
				'p1'=>'Saat mengisi data,&nbsp;pastikan tidak merubah format kolom dan baris. Unduh berkas,&nbsp;modifikasi,&nbsp;dan simpan (save as) dengan ekstensi .csv',
				'p2'=>'Klik icon berkas untuk mengunduh.'
			],
			[
				'h4'=>'Unggah Berkas Tabel',
				'p1'=>'Unggah berkas yang telah disimpan dengan ekstensi .CSV',
			]
		],
		'finger'=>[
			['h6'=>'Jam Masuk', 'p'=>'Jam masuk menggunakan format waktu 24 jam [jam]:[menit]:[detik].'],
			['h6'=>'Jam Keluar', 'p'=>'Isi salah satu Jam Keluar sesuai waktu finger. Jam keluar menggunakan format waktu 24 jam [jam]:[menit]:[detik].'],
		],
		'consent'=>[
			['h6'=>'Tanggal Izin/Cuti', 'p'=>'Pilih tanggal minimal sama dengan tanggal awal. Jika melewati tanggal libur (sesuai kalender hari libur),&nbsp;sistem otomatis menghitung jumlah cuti tanpa menghiraukan hari libur.'],
			['h6'=>'Jenis Izin/Cuti', 'p'=>'Sesuaikan jenis izin/cuti.'],
			['h6'=>'Berkas Izin/Cuti', 'p'=>'Unggah berkas sebagai bukti izin/cuti. Unggah berkas dengan ekstensi PDF atau JPG/JPEG. Berkas.'],
		]
	],
];