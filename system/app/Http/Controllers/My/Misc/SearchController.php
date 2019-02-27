<?php
namespace App\Http\Controllers\My\Misc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller{
	
	public function searchEmployee(Request $req){
		$keywords = $req->input('keywords', false);
		$active = $req->input('active', false);
		if (!$keywords) return response()->json([]);
		
		$schema = new \App\Libraries\Core\Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Core\Phone();
		$phoneSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new \App\Libraries\Bauk\Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = \App\Libraries\Bauk\Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id')
            ->join($phoneSchema, $personSchema.'.id', '=', $phoneSchema.'.person_id')
			->where($phoneSchema.'.default','=',1)
			->groupBy($employeeSchema.'.nip')
			->orderBy('nip', 'asc')
			->orderBy('active', 'desc')
			->select([
				$employeeSchema.'.id as id',
				$employeeSchema.'.nip',
				$personSchema.'.name_front_titles',
				$personSchema.'.name_full',
				$personSchema.'.name_back_titles',
			]);
		
		if ($keywords){
			$employee->where(function($q) use ($personSchema, $phoneSchema, $employeeSchema, $keywords){
				$q->where($employeeSchema.'.nip','like','%'.$keywords.'%');
			})->orWhere(function($q) use ($personSchema, $phoneSchema, $employeeSchema, $keywords){
				$q->where($personSchema.'.name_full','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_front_titles','like','%'.$keywords.'%');
				$q->orWhere($personSchema.'.name_back_titles','like','%'.$keywords.'%');
			});
		}
		
		if ($active){
			$employee->where($employeeSchema.'.active','=',$active);
		}
		
		return response()->json($employee->get());
	}
	
}