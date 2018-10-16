<?php

namespace App\Http\Controllers\BAUK;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MnjKaryawanController extends Controller {
    public function save(Request $req){
		$model = new \App\DBModels\JNBauk\Karyawan($req->all());
		$model->tanggal_masuk = \DateTime::createFromFormat("d-m-Y", $model->tanggal_masuk)->format("Y-m-d");
		$model->save();
		return redirect()->route('bauk.mnjkaryawan');
	}
	
	public function isUniqueNIP(Request $request){
		$NIP = $request->input('NIP');
		$karyawan = \App\DBModels\JNBauk\Karyawan::where('NIP','=',$NIP)->first();
		if ($karyawan){
			return response()->json(false);
		}
		return response()->json(true);
	}
}