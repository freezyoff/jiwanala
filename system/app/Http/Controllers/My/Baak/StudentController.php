<?php 
namespace App\Http\Controllers\My\Baak;

use Illuminate\Http\Request;
use App\Http\Requests\My\Baak\Student\PostRequest;
use App\Http\Controllers\Controller;

class StudentController extends Controller{
	
	public function index(){
		return view('my.baak.student.landing',[
			'students'=>[]
		]);
	}
	
	public function add(Request $req){
		return view('my.baak.student.add');
	}
	
	public function store(PostRequest $req){
		return $req->all();
	}
	
}