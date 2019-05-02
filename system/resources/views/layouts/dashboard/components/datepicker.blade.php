<?php
/*
 *	String $id 					- input element id
 *	String $name 				- input element name
 *	String $value 				- input element value
 *	String $placeholder 		- input element placeholder
 *	String $modalIconClass 		- input element placeholder
 *	String $modalTitle			- input element placeholder
 *	String $startDateLimiter	- id of datepicker for limiting start date
 */
$id = isset($id)? $id : str_replace('-','',\Illuminate\Support\Str::uuid());
$functionStamp = 'datepicker_'.$id;
$prefixName = ['large','small'];
$role = ['dropdown','modal'];
$link = [
	'input#'.$id.'-'.$prefixName[0],
	'input#'.$id.'-'.$prefixName[1],
];

if (!isset($class)){
	$class = [
		'w3-input w3-hide-small w3-hide-medium',
		'w3-input w3-hide-large'
	];
}

$value = !isset($value)? '' : $value;
$modal = !isset($modal)? '' : $modal;
$modalContainer = !isset($modalContainer)? '' : $modalContainer;

if (isset($startDateLimiter)){
	$startDateLimiter = 'datepicker_'.$startDateLimiter;
}

?>

<input id="{{isset($id)? $id : $name}}"  
	name="{{$name}}"
	value="{{$value}}"
	type="hidden" />
@foreach($prefixName as $prefix)
	<input id="{{$id}}-{{$prefix}}"
		name="{{$name}}-{{$prefix}}" 
		value="{{$value}}" 
		placeholder="{{$placeholder}}"
		type="text" 
		class="{{$class[$loop->index]}}"
		autocomplete="off"
		readonly="readonly"
		/>
@endforeach
<div id="{{$id}}-{{$prefixName[1]}}-modal" 
	class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
	onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#{{$id}}-{{$prefixName[1]}}-modal').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				@if (isset($modalIconClass))
				<i class="{{$modalIconClass}}"></i>
				@endif
				<span style="padding-left:12px;">{{isset($modalTitle)? $modalTitle : ''}}</span>
			</h4>
		</header>
		<div id="{{$id}}-{{$prefixName[1]}}-modal-container" class="datepicker-inline-container"></div>
	</div>
</div>
<script>
var {{$functionStamp}} = {
	options:{
		float: {format: 'dd-mm-yyyy', offset: 5, autoHide:true, language: 'id-ID'},
		modal: {
			format: 'dd-mm-yyyy', 
			offset: 5, 
			container: 'div#{{$id}}-{{$prefixName[1]}}-modal-container', 
			inline: true, language: 'id-ID'
		}
	},
	input:{
		source:$('input#{{$id}}'),
		large: $('input#{{$id}}-{{$prefixName[0]}}'),
		small: $('input#{{$id}}-{{$prefixName[1]}}')
	},
	sync: function(){
		var val = {{$functionStamp}}.input.source.val();
		{{$functionStamp}}.input.large.val(val);
		{{$functionStamp}}.input.small.val(val);
	},
	hide: function(){
		{{$functionStamp}}.input.large.datepicker('hide');
		$('div#{{$id}}-{{$prefixName[1]}}-modal').hide();
	},
	init: function(){
		$(window).resize( {{$functionStamp}}.hide );
		
		{{$functionStamp}}.input.source.on('datepicker.sync', {{$functionStamp}}.sync);
		
		//datepicker role dropdown
		{{$functionStamp}}.input.large.datepicker( {{$functionStamp}}.options.float )
			.on('pick.datepicker', function(event){
				{{$functionStamp}}.input.source
					.val($(this).datepicker('getDate',true))
					.trigger('datepicker.sync');
				{{$functionStamp}}.hide();
			});
		
		//datepicker role modal
		{{$functionStamp}}.input.small
			.datepicker( {{$functionStamp}}.options.modal )
			.on('click focusin', function(event){
				$('div#{{$id}}-{{$prefixName[1]}}-modal').show();
			})
			.on('pick.datepicker', function(){
				{{$functionStamp}}.input.source
					.val($(this).datepicker('getDate',true))
					.trigger('datepicker.sync');
				{{$functionStamp}}.hide();
			});
		
		@if (isset($startDateLimiter))
			$.each([{{$startDateLimiter}}.input.large, {{$startDateLimiter}}.input.small], function(index, item){
				$(this).on('pick.datepicker',function(){
					var xx = $(this).datepicker('getDate');
					var yy = {{$functionStamp}}.input.large.datepicker('getDate');
					var rr = null;
					if (xx < yy) {
						rr = yy; 
					}else if (xx > yy){
						rr = xx; 
					}else {
						rr = xx;
					}
					{{$functionStamp}}.input.small.datepicker('setDate', rr).datepicker('setStartDate', xx);
					{{$functionStamp}}.input.large.datepicker('setDate', rr).datepicker('setStartDate', xx);
					{{$functionStamp}}.input.source.val({{$functionStamp}}.input.large.val()).trigger('datepicker.sync');
				});
			});	
			
			//trigger pick if not empty value
			if ({{$startDateLimiter}}.input.large.val() != ""){
				{{$startDateLimiter}}.input.large.trigger('pick.datepicker');
			}
		@endif
	}
};

$(document).ready(function(){
	{{$functionStamp}}.init();
});
</script>