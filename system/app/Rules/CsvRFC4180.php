<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CsvRFC4180 implements Rule
{
	protected $delimiter = ",";
	protected $enclosure = "\"";
	
	protected $errorLine = 0;
	
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
    public function message()
    {
        return 'Not valid CSV RFC4180 format. Please check line '.$this->errorLine;
    }
}
