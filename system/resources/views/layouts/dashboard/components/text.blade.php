<?php 
	$icon = 		isset($icon)? $icon : '';
	$value = 		isset($value)? $value : old($name, '');
	$placeholder = 	isset($placeholder)? $placeholder : $name;
	$errorMessage = isset($errorMessage)? $errorMessage : '';
	$class = 		isset($class)? $class : '';
	$error = 		$errorMessage || $errors->has($name)? 'error' : '';
?>
<div class="input-group">
	<label><i class="{{$icon}}"></i></label>
	<input name="{{$name}}" type="text" value="{{$value}}" 
		placeholder="{{$placeholder}}" 
		class="w3-input {{$class}} {{$error}}"/>
</div>
@if( $errorMessage )
	<label class="w3-text-red">{{$errorMessage}}</label>
@elseif (isset($errors) && $errors->has($name))
	<label class="w3-text-red">{{$errors->first($name)}}</label>
@else
	<label>&nbsp;</label>
@endif