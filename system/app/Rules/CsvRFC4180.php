<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CsvRFC4180 implements Rule
{
	protected $delimiter = ";";
	protected $enclosure = "\"";
	
	protected $errorLine = 0;
	
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($expectedHeaderColumnCount, $delimiter=';', $enclosure='"'){
		$this->delimiter = $delimiter;
		$this->enclosure = $enclosure;
	}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
		try{
			$handle = fopen($value, "r");
			if ($handle) {
				$counter = 1;
				while (($line = fgets($handle)) !== false) {
					$line = str_replace(["\n","\r"], "", $line);
					$array = explode(",",$line);
					if (count($array)!=6) {
						$this->errorLine = $counter;
						return false;
					}
					$counter++;
				}
				fclose($handle);
			}
			return true;
		}
		catch (Exception $exception){	
			return false;
		}
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(){
        return str_replace(
			[':delimiter', ':enclosure', ':line'], 
			[$this->delimiter, $this->enclosure, $this->errorLine], 
			trans('validation.csvRFC4180'));
    }
}
