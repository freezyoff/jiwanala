<?php 
	
	$id = isset($id)? $id : str_replace('-','',\Illuminate\Support\Str::uuid());
	$modal = isset($modal)? $modal : $dropdown;
	$modalIcon = isset($modalIcon)? $modalIcon : '';
	
?>
<input id="{{ $id }}" 
	name="{{ $name }}"
	value="{{ $value }}"
	type="text" 
	class="w3-input" 
	role="select"
	select-dropdown="#{{ $id }}-dropdown"
	select-modal="#{{ $id }}-modal"
	select-modal-container="#{{ $id }}-modal-container" />

<div id="{{ $id }}-dropdown" 
	class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium"
	style="z-index:100">
	<ul class="w3-ul w3-hoverable">
		@if (is_array($dropdown))
			@include($dropdown[0],$dropdown[1])
		@else
			{{$dropdown}}
		@endif
	</ul>
</div>

<div id="{{ $id }}-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
				onclick="$('#{{ $id }}-modal').hide()">
				×
			</h4>
			<h4 class="padding-top-8 padding-bottom-8">
				<i id="{{$id}}-modal-icon" class="{{$modalIcon}} fa-fw"></i>
				<span class="padding-left-8">{{$modalTitle}}</span>
			</h4>
		</header>
		<div id="{{ $id }}-modal-container" class="datepicker-inline-container">
			<div class="w3-bar-block" style="width:100%">
				<ul class="w3-ul w3-hoverable">
					@if (is_array($modal))
						@include($modal[0],$modal[1])
					@else
						{{$modal}}
					@endif
				</ul>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){

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
	
	$('input#{{$id}}').select();
});
</script>