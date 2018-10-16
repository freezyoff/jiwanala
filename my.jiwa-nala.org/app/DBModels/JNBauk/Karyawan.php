<?php

namespace App\DBModels\JNBauk;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
	protected $connection = 'jn_bauk';
	
	protected $fillable = [
		'NIP',
		'KTP',
		'nama_gelar_depan',
		'nama_lengkap',
		'nama_gelar_belakang',
		'alamat',
		'rt',
		'rw',
		'kelurahan',
		'kecamatan',
		'kota',
		'provinsi',
		'kode_pos',
		'tlp1',
		'tlp2',
		'status_pernikahan',
		'tanggal_masuk',
	];
}
