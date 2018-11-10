<?php

namespace App\DBModels\JNBauk;

use Illuminate\Database\Eloquent\Model;
use App\DBModels\JNBauk\KaryawanExporter;

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
		'aktif'
	];
	
	public static function export($format, $fileName){
		$mimes = [
			'XLS'=> \Maatwebsite\Excel\Excel::XLS,
			'XLSX'=> \Maatwebsite\Excel\Excel::XLSX,
			'PDF'=> \Maatwebsite\Excel\Excel::DOMPDF,
			'CSV'=> \Maatwebsite\Excel\Excel::CSV
		];
		
		$mime = "";
		
		//check is correct mime
		$format = strtoupper($format);
		if (array_key_exists($format, $mimes)){ 
			$mime = $mimes[$format];
		}
		else{
			$mime = $mimes['CSV'];
		}
		
		//check if has mime type format
		return (new KaryawanExporter)->download($fileName.'.'.strtolower($format), $mime);
	}
}