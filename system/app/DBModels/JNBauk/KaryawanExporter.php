<?php
namespace App\DBModels\JNBauk;

use App\DBModels\JNBauk\Karyawan;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class KaryawanExporter implements FromQuery
{
    use Exportable;

	protected $QUERY = null;
	
	/*
	 *	@param $options (array) - [ [key, logic, value], ... ]
	 */
	public function __construct($options=[]){
		$this->setQuery(Karyawan::query());
        foreach($options as $option){
			$this->for($option[0],$option[1],$option[2]);
		}
    }
	
	public function getQuery(){
		return $this->QUERY;
	}
	
	public function setQuery($query){
		$this->QUERY = $query;
	}
	
	public function for($key, $logicOperation, $value){
		$this->getQuery()->where($key, $logicOperation, $value);
		return $this;
	}
	
    public function query()
    {
        return $this->getQuery();
    }
}
