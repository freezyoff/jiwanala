<?php 
namespace App\Http\Controllers\My;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaakController extends Controller{
	
	public function index(){
		return view('my.baak.landing');
	}
	
}