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
	],
	
	'errors'=>[
		'consentType'=>'Pilih salah satu jenis Cuti/Izin',
		'noFileUploaded'=>'Sertakan dan upload dokumen Cuti/Izin',
		'uploadConnectionTimeout'=>'Tidak dapat menghubungi server. Mohon cek koneksi.',
		'uploadFileTooLarge'=>'Besar file melebihi 16 Mb',
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
	]
];