<?php
/*
 *	String $id 					- input element id
 *	String $name 				- input element name
 *	String $value 				- input element value
 *	String $class 				- input element class
 *	String $placeholder			- input element placeholder
 *	String $modalIcon	 		- Icon for modal class
 *	String $modalTitle 			- Title for modal
 *	String $timeFormat 			- array[input: , output: ]
 */
 
$id = isset($id)? $id : str_replace('-','',\Illuminate\Support\Str::uuid());
$prefixName = ['large','small']; 
$value = isset($value)? $value : '';
$defClass = [
	'timepicker w3-input input w3-hide-small w3-hide-medium ', 
	'timepicker w3-input input w3-hide-large'
];
$class = isset($class)? $class : '';

$placeholder = isset($placeholder)? $placeholder : '';
$modalIcon = isset($modalIcon)? $modalIcon : '';
?>

<!-- timepicker source -->
<input id="{{$id}}" 
	name="{{$name}}" 
	value="{{$value}}"
	type="hidden" />
<!-- end: timepicker source -->

<!-- start: timepicker large -->
<input id="{{$id}}-{{$prefixName[0]}}" 
	name="{{$name}}-{{$prefixName[0]}}"
	class="{{$defClass[0]}} {{$class}}" 
	type="text" 
	timepicker-source="input#{{$id}}"
	timepicker-link="input#{{$id}}-{{$prefixName[1]}}"
	timepicker-container="div#{{$id}}-dropdown"
	readonly="readonly" 
	placeholder="{{$placeholder}}"/>
<!-- end: timepicker large -->

<!-- start: timepicker small -->
<input id="{{$id}}-{{$prefixName[1]}}" 
	name="{{$name}}-{{$prefixName[1]}}"
	class="{{$defClass[1]}} {{$class}}" 
	type="text" 
	timepicker-source="input#{{$id}}"
	timepicker-link="input#{{$id}}-{{$prefixName[0]}}"
	timepicker-modal="div#{{$id}}-modal"
	timepicker-container="div#{{$id}}-modal-container"
	readonly="readonly" 
	placeholder="{{$placeholder}}"/>
<!-- end: timepicker small -->

<!-- start: dropdown container -->
<div class="w3-dropdown-click w3-hide-small" style="display:block">
	<div id="{{$id}}-dropdown" class="w3-dropdown-content w3-bar-block w3-border"></div>
</div>
<!-- end: dropdown container -->

<!-- start: modal container -->
<div id="{{$id}}-modal" 
	class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
	onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:300px; margin:auto;">
		<header class="w3-container w3-theme">
			<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
				onclick="$('div#{{$id}}-modal').hide()" >
				×
			</h4>
			<h4 class="padding-top-8 padding-bottom-8">
				<i id="{{$id}}-modal-icon" class="{{$modalIcon}} fa-fw"></i>
				<span style="padding-left:12px;">{{$modalTitle}}</span>
			</h4>
		</header>
		<div id="{{$id}}-modal-container" class="datepicker-inline-container"></div>
	</div>
</div>
<!-- end: modal container -->

<script>
$(document).ready(function(){
	//inject dropdown to outer parent
	//$('div#{{$id}}-dropdown').parent().insertAfter(
	//	$('input#{{$id}}').parent()
	//);
	
	@if (empty($modalIcon))
	if ($('input#{{$id}}').parent().has('input-group')){
		$.each($('input#{{$id}}').parent()
			.find(">:first-child")
			.find('i')
			.attr('class')
			.split(' '), function(index, item){
				$('i#{{$id}}-modal-icon').addClass(item);
			});
	}	
	@endif
	
	$.each(['input#{{$id}}-{{$prefixName[0]}}', 'input#{{$id}}-{{$prefixName[1]}}'], function(index, item){
		$(item).timepicker({
			parseFormat: '{{ isset($timeFormat['input'])? $timeFormat['input'] : 'HH:mm:ss'}}',
			outputFormat: '{{ isset($timeFormat['output'])? $timeFormat['output'] : 'HH:mm:ss'}}'
		});
	});
});
</script>