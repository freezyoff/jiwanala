<?php
$head = ['Record ID','NIP','KTP','Gelar Depan','Nama','Gelar Belakang','Alamat','RT','RW','Kelurahan','Kecamatan',
	'Kota','Provinsi','Kodepos','Telepon 1','Telepon 2','Status Pernikahan','Tanggal Aktif','Tanggal Non Aktif',
	'Aktif'
];

$keys = ['id','NIP','KTP','nama_gelar_depan','nama_lengkap','nama_gelar_belakang','alamat','rt','rw','kelurahan',
	'kecamatan','kota','provinsi','kode_pos','tlp1','tlp2','status_pernikahan','tanggal_masuk','tanggal_keluar',
	'aktif'
];
?>

<table>
    <thead>
		<tr>
			@foreach($head as $title)
				<th>{{ $title }}</th>
			@endforeach
		</tr>
    </thead>
    <tbody>
    @foreach($data as $item)
        <tr>
			@foreach($keys as $key)
            <td>{{ $item[$key] }}</td>
			@endforeach
        </tr>
    @endforeach
    </tbody>
</table>