<?php 
namespace App\Http\Controllers\My\Misc;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Libraries\Bauk\Employee;
use App\Libraries\Baak\Student;
use App\Libraries\Core\Person;
use App\Libraries\Core\Phone;

class SearchController extends Controller{
	
	public function searchEmployee(Request $req){
		$keywords = $req->input('keywords', false);
		$active = $req->input('active', false);
		if (!$keywords) return response()->json([]);
		
		$schema = new Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new Phone();
		$phoneSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new Employee();
		$employeeSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$employee = Employee::join($personSchema, $personSchema.'.id', '=', $employeeSchema.'.person_id')
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
	
	public function searchStudent(Request $req){
		$keywords = $req->input('keywords', false);
		$active = $req->input('active', false);	
		if (!$keywords) return response()->json([]);
		
		$schema = new Person();
		$personSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		$schema = new Student();
		$studentSchema = $schema->getConnection()->getDatabaseName().'.'.$schema->getTable();
		
		$student = Student::join($personSchema, $personSchema.'.id', '=', $studentSchema.'.person_id')
			->groupBy($studentSchema.'.id')
			->orderBy('nip', 'asc')
			->orderBy('active', 'desc')
			->select([
				$employeeSchema.'.id as id',
				$employeeSchema.'.nip',
				$personSchema.'.name_front_titles',
				$personSchema.'.name_full',
				$personSchema.'.name_back_titles',
			]);
	}
	
	public function searchStudentParent(Request $req){
		
	}
	
}