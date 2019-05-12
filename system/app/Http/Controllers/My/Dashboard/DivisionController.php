<?php

namespace App\Http\Controllers\My\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Core\Division;

class DivisionController extends Controller
{
    public function index(){
		$divisions = \Auth::user()->getRoleOption('division.manager', 'divisions');
		if (is_array($divisions) && !empty($divisions)){			
			$divisions = Division::where(function($q) use ($divisions){
				foreach($divisions as $div){
					$q->orWhere('id',$div);
				}
			})->get();
		}
		else{
			$divisions = [];
		}
		return  view('my.dashboard.division.landing', [
			'divisions'=>$divisions,
		]);
	}
}
