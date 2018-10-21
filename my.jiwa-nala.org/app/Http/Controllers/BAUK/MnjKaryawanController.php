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
	
	public function update(Request $req){
		if (!$req->has('recordID')){
			return redirect()->route('bauk.mnjkaryawan');
		}
		
		if (!$req->has('submit') && !$req->has('simpan')){
			$karyawan = \App\DBModels\JNBauk\Karyawan::find($req->recordID);
			return view('bauk.default.mnjkaryawan.rubah', ['karyawan'=>$karyawan]);
		}
		
		//have an ID variable and Save Button clicked 
		$model = \App\DBModels\JNBauk\Karyawan::find($req->recordID);
		$model->fill($req->all());
		$model->tanggal_masuk = \DateTime::createFromFormat("d-m-Y", $model->tanggal_masuk)->format("Y-m-d");
		$model->save();
		return redirect()->route('bauk.mnjkaryawan');
	}
	
	public function delete(Request $req){
		if ($req->has('recordID')){
			$model = \App\DBModels\JNBauk\Karyawan::find($req->recordID);
			$model->delete();
		}
		return redirect()->route('bauk.mnjkaryawan');
	}
	
	public function isUniqueNIP(Request $request){
		$NIP = $request->input('NIP');
		$ID = $request->input('recordID');
		$karyawan = \App\DBModels\JNBauk\Karyawan::where('NIP','=',$NIP)->first();
		if ($karyawan){
			if ($karyawan->id == $request->input('recordID')){
				return response()->json(true);
			}
			return response()->json(false);
		}
		return response()->json(true);
	}
	
	public function getTableDataKarayawan(Request $request){
		$perpage = $request->input('pagination.perpage');
		$page = $request->input('pagination.page');
		$sort = $request->input('sort.sort',"asc");
		$field = $request->input('sort.field',"NIP");
		
		$queryData = \App\DBModels\JNBauk\Karyawan::select(
			'id',
			'NIP', 
			'nama_gelar_depan',
			'nama_lengkap',
			'nama_gelar_belakang',
			'tlp1',
			'tlp2',
			\DB::raw("DATE_FORMAT(`tanggal_masuk`, '%d %m %Y') as tanggal_masuk"),
			'aktif'
		)->orderBy($field, $sort);
		
		$queryTotal = \App\DBModels\JNBauk\Karyawan::select('NIP')->count();
		
		return response()->json([ 
			"oldInput" => $request->input(),
			"meta" => [
				"page"=> $page,
				"perpage"=> $perpage,
				"pages"=> ceil($queryTotal/$perpage),
				"total"=> $queryTotal,
				"sort"=> $sort,
				"field"=> $field
			],
			"data" => $queryData->offset(($page-1)*$perpage)->limit($perpage)->get(),
		]);
	}
}