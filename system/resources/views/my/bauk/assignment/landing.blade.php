@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/assignment.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-card">
		<header class="w3-container padding-top-bottom-8 w3-theme">
			<h4>{{trans('my/bauk/assignment.subtitle')}}</h4>
		</header>
		<div class="w3-container">
			<form action="{{route('my.bauk.assignment.landing')}}" method="POST">
				@csrf
				<div class="w3-col s12 m4 l4">
					<div class="input-group padding-left-8 padding-none-small">
						<label><i class="fas fa-university"></i></label>
						<?php 
							$divisionInputID = str_replace('-','',\Illuminate\Support\Str::uuid());
							$dropdown = [
								'id'		=> $divisionInputID,
								'name'		=> 'division',
								'value'		=> old('division', isset($division)? $division->id : ''),
								'dropdown'	=> ['my.bauk.assignment.landing_division_select', []],
								'modalTitle'=> trans('my/bauk/assignment.modal.divisions')
							];
						?>
						@include('layouts.dashboard.components.select', $dropdown)
					</div>
				</div>
			</form>
		</div>
		<div class="w3-row w3-hide-small">
			@include('my.bauk.assignment.landing_medium_large')
		</div>
		<div class="w3-row w3-hide-medium w3-hide-large">
			@include('my.bauk.assignment.landing_small')
		</div>
	</div>
</div>

@include('my.bauk.assignment.landing_error_modal')

@endSection

@section('html.head.styles')
@parent
<style>
	a.action + a.action,
	a.action + a.action { padding-left:8px; }
</style>
@endSection

@section('html.body.scripts')
@parent
<script>
var toggleClickable = function(clickable){
	var icon = $(clickable).find('i');
	if (icon.attr('class') == 'button-icon-loader'){
		var icon = $(clickable).find('i');
		icon.attr('class', icon.attr('def-class') );
	}
	else{		
		icon.attr('def-class', icon.attr('class') );
		icon.attr('class','button-icon-loader');
	}
};

var handleError = function(statusCode){
	var msg = "";
	switch(statusCode){
		case 500: msg = "{{trans('my/bauk/assignment.errors.500')}}"; break;
		default: msg = "{{trans('my/bauk/assignment.errors.default')}}";
	}
	$('#error-modal-container>p').html(msg);
	$('#error-modal').show();
};

var doAssign = function(clickable){
	$.ajax({
		url: $(clickable).attr('trigger-href'),
		beforeSend: function(){ toggleClickable(clickable); },
		error: function(xhr, status, error) { toggleClickable(clickable); handleError(xhr.status); },
		success: function(data){
			$('div.employee-list.table-assigned').html(data);
			$(clickable).parents('tr').remove();
		}
	});
};

var doRelease = function(clickable){
	$.ajax({
		url: $(clickable).attr('trigger-href'),
		beforeSend: function(){ toggleClickable(clickable); },
		error: function(xhr, status, error) { toggleClickable(clickable); handleError(xhr.status); },
		success: function(data){
			$('div.employee-list.table-unassigned').html(data);
			$(clickable).parents('tr').remove();
		}
	});
};

$(document).ready(function(){
	$('#{{$divisionInputID}}').change(function(){
		$(this).parents('form').trigger('submit');
	});
});
</script>
@endSection