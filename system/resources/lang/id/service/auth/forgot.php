<?php return[
	'label'=>[
		'info'=>'Link untuk merubah password akan dikirim melalui email, pastikan email terdaftar pada sistem.'
	],
	'hints'=>[
		'email'=>'Alamat Email',
		'button'=>'Kirim Link'
	],
	'error'=>[
		'email'=>[
			'email.required'=>'Isi dengan alamat email yang terdaftar.',
			'email.email'=>'Format email tidak valid.',
			'email.exists'=>'Email tidak terdaftar pada sistem.',
		],
	],
	'success'=>'Email Atur Ulang Sandi telah dikirim.',
	'failed'=>'Kelasahan server, email belum dikirim.'
];