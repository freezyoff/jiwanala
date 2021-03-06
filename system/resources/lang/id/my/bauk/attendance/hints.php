<?php return[
	'tags'=>[
		'upload_success'=>'Impor Sukses',
		'upload_failed'=>'Impor Gagal',
		'upload_ignored'=>'Impor Diabaikan',
		'upload_item_uploaded'=>'diimpor',
		'upload_item_ignored'=>'diabaikan',
	],
	'table'=>[
		'head'=>[
			'Hari / Tanggal',
			'Kehadiran / Izin'
		],
		'empty'=>'Masukkan NIP dan Periode untuk melihat data.',
		'upload_report'=>[
			'Baris',
			'Sukses / Gagal'
		],
		'export'=>[
			'work_days'=>'Hari Kerja',
			'attends'=>'Hadir',
			'absents'=>'Tidak Hadir',
			'attendance'=>'Kehadiran',
			'attends_lateArrival'=>'Terlambat',
			'attends_earlyDeparture'=>'Pulang Awal',
			'attends_noLateOrEarlyConsent'=>'Tanpa Dokumen<br>(Terlambat / Pulang Awal)',
			'attends_noArrival'=>'Tidak Finger Datang',
			'attends_noDeparture'=>'Tidak Finger Pulang',
			'attends_noArrivalOrDepartureConsent'=>'Tanpa Dokumen<br>(Tidak Finger Datang / Pulang)',
			'absents_consentSick'=>'Izin Sakit',
			'absents_consentDuty'=>'Izin Tugas',
			'absents_consentAnnual'=>'Cuti Tahunan',
			'absents_consentOthers'=>'Cuti Lainnya',
			'absents_noConsent'=>'Tanpa Dokumen<br>(Izin / Cuti)',
		]
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
		'fileMimeExtensionInvalid'=>'Unggah file dengan ekstensi .csv'
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
		'notAllowedByPeriode'=>'Tanggal :value sudah melewati periode pelaporan.',
		'holiday'=>'Tanggal :value hari libur :name',
		'dayoff'=>'Tidak memiliki jadwal kerja pada hari :day tanggal :date',
		
		//import
		'import'=>[
			'no.required'=>'Isi nomor baris',
			'nip.required'=>'Isi NIP',
			'nip.numeric'=>'Isi NIP dengan angka',
			'nip.exists'=>'NIP tidak terdaftar',
			'tanggal.required'=>'Isi Tanggal dengan format: [tgl]/[bln]/[thn]',
			'tanggal.date_format'=>'Gunakan format Tanggal: [tgl]/[bln]/[thn]',
			'finger_masuk.required'=>'Isi dengan format Waktu 12 Jam : 00:00:00 AM/PM',
			'finger_masuk.regex'=>'Gunakan format Waktu 12 Jam : 00:00:00 AM/PM',
			'finger_masuk.required_if'=>'Isi salah satu (Finger Masuk, Finger Keluar 1, Finger Keluar 2 atau Finger Keluar 3)',
			'finger_keluar_1.required'=>'Isi dengan format Waktu 12 Jam : 00:00:00 AM/PM',
			'finger_keluar_1.regex'=>'Gunakan format Waktu 12 Jam : 00:00:00 AM/PM',
			'finger_keluar_1.required_if'=>'Isi salah satu (Finger Masuk, Finger Keluar 1, Finger Keluar 2 atau Finger Keluar 3)',
			'finger_keluar_2.regex'=>'Gunakan format Waktu 12 Jam : 00:00:00 AM/PM',
			'finger_keluar_3.regex'=>'Gunakan format Waktu 12 Jam : 00:00:00 AM/PM',
			
			'*.no.required'=>'Isi nomor baris',
			'*.nip.required'=>'Isi NIP',
			'*.nip.numeric'=>'Isi NIP dengan angka',
			'*.nip.exists'=>'NIP tidak terdaftar',
			'*.tanggal.required'=>'Isi Tanggal dengan format: [tgl]/[bln]/[thn]',
			'*.tanggal.date_format'=>'Gunakan format Tanggal: [tgl]/[bln]/[thn]',
			'*.finger_masuk.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_masuk.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_masuk.required_if'=>'Isi salah satu (Finger Masuk, Finger Keluar 1, Finger Keluar 2 atau Finger Keluar 3)',
			'*.finger_keluar_1.required'=>'Isi dengan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_1.regex'=>'Gunakan format Waktu 12 Jam : [jam]:[menit]:[detik] AM/PM',
			'*.finger_keluar_1.required_if'=>'Isi salah satu (Finger Masuk, Finger Keluar 1, Finger Keluar 2 atau Finger Keluar 3)',
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
				'p1'=>'Saat mengisi data, pastikan tidak merubah format kolom dan baris. Unduh berkas, modifikasi, dan simpan (save as) dengan ekstensi .csv .',
				'p2'=>'Untuk menghindari kesalahan saat proses upload, baca tabel berikut:',
				'p3'=>'<code>No</code>',
				'p4'=>'Sesuai urutan data untuk memudahkan cek ulang.',
				'p5'=>'<code>NIP</code>',
				'p6'=>'Pastikan NIP terdaftar. Cari nomor <code>NIP</code> pada halaman riwayat jika dirasa perlu.',
				'p7'=>'<code>Tanggal</code>',
				'p8'=>'Pastikan menggunakan format 00-00-0000 (tgl-bln-thn) dan pastikan tidak ada pengulangan tanggal pada baris lainnya. Apabila ada, data akan ditumpuk secara berurutan dari baris paling atas ke bawah',
				'p9'=>'<code>Finger Masuk</code>',
				'p10'=>'Pastikan menggunakan format 00:00:00 AM/PM (jam:menit:detik Ante/Post Meridiem).',
				'p11'=>'<code>Finger Keluar</code>',
				'p12'=>'Pastikan menggunakan format 00:00:00 AM/PM (jam:menit:detik Ante/Post Meridiem).',
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
		],
	],
	
	'warnings'=>[
		'lateArrival'=>'Datang terlambat :jam Jam :menit Menit :detik Detik.',
		'earlyDeparture'=>'Pulang awal :jam Jam :menit Menit :detik Detik.',
		'noArrival'=>'Tidak finger datang.',
		'noDeparture'=>'Tidak finger pulang.',
		'noConsent'=>'Belum melaporkan dokumen Cuti / Izin.',
		'noOverDueConsent'=>'Alpha',
		'offschedule'=>'Libur hari :day'
	],
];