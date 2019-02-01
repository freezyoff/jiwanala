<?php

namespace App\Http\Controllers\My\Bauk;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\My\Bauk\Holiday\PostRequest;
use App\Http\Requests\My\Bauk\Holiday\PatchRequest;
use App\Libraries\Bauk\Holiday;

class HolidayController extends Controller
{
    public function landing(Request $req){
		$year = $req->input('year', now()->year);
		return view('my.bauk.holiday.landing',[
			'holidays'=> Holiday::getHolidaysByYear($year),
			'year'=>$year
		]);
	}
	
	public function showAdd(){
		return view('my.bauk.holiday.add');
	}
	
	public function add(PostRequest $req){
		/*{
			"_token":"",
			"start":"11-12-2018",
			"end":"18-12-2018",
			"name":null,
			"startlarge":"11-12-2018",
			"startsmall":"11-12-2018",
			"endsmall":"18-12-2018",
			"repeat":null
		}*/
		
		$holiday = new \App\Libraries\Bauk\Holiday([
			"name"=> $req->name,
            "start"=> \Carbon\Carbon::createFromFormat('d-m-Y', $req->start),
			"end"=> \Carbon\Carbon::createFromFormat('d-m-Y', $req->end),
			"repeat"=> $req->repeat,
			'creator'=> \Auth::user()->id
		]);
		$holiday->save();
		return redirect()->route('my.bauk.holiday.landing');
	}
	
	public function showEdit(Request $req, $id){
		$holiday = Holiday::find($id);
		return view('my.bauk.holiday.edit',[
			'holiday'=>$holiday,
		]);
	}
	
	public function edit(PatchRequest $req){
		/*{
			"_token":"",
			"id":"1",
			"start":"11-12-2018",
			"end":"18-12-2018",
			"name":null,
			"startlarge":"11-12-2018",
			"startsmall":"11-12-2018",
			"endsmall":"18-12-2018",
			"repeat":null
		}*/
		$holiday = Holiday::find($req->input('id'))->fill(
			$req->only(['start','end','name','start','end','repeat'])
		);
		$holiday->save();
		return redirect()->route('my.bauk.holiday.landing');
	}
	
	public function delete(Request $req){
		$id = $req->input('id',false);
		if ($id){
			$holiday->find($id);
			$holiday->delete();
		}
		return redirect()->route('my.bauk.holiday.landing');
	}
}
