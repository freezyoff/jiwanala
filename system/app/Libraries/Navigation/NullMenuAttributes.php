<?php 
namespace App\Libraries\Navigation;

class NullMenuAttributes{
	public function isNull(){
		return true;
	}
	
	public function __get($name){
		return new NullMenuAttributes();
	}
	
	public function __toString(){
		return "";
	}
}