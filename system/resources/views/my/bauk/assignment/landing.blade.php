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
						<input id="division" 
							name="division" 
							type="text" 
							class="w3-input" 
							value="{{old('division', isset($division)? $division->code : '')}}" 
							select-role="dropdown"
							select-dropdown="#division-dropdown" 
							select-modal="#division-modal"
							select-modal-container="#division-modal-container" />
					</div>
					@include('my.bauk.assignment.landing_division_dropdown_and_modal')
				</div>
			</form>
		</div>
		<div class="w3-container margin-top-16">
			<div class="w3-bar w3-theme-l2">
				<button class="w3-bar-item w3-button w3-blue" target="#unassigned">Belum Bertugas</button>
				<button class="w3-bar-item w3-button" target="#assigned">Telah Bertugas</button>
			</div>
		</div>
		<div class="w3-container padding-bottom-16">
			<div id="unassigned" class="employee-list w3-responsive">
				@include('my.bauk.assignment.landing_table',['mode'=>'assign', 'employees'=>$unassigned])
			</div>
			<div id="assigned" class="employee-list w3-responsive" style="display:none">
			  @include('my.bauk.assignment.landing_table',['mode'=>'release', 'employees'=>$assigned])
			</div>
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
			$('div#assigned').html(data);
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
			$('div#unassigned').html(data);
			$(clickable).parents('tr').remove();
		}
	});
};

var doAssignAs = function(clickable){
	$.ajax({
		url: $(clickable).attr('trigger-href'),
		beforeSend: function(){ 
			toggleClickable(clickable); 
			var citem = $(clickable);
			$($('a.action')).each(function(index, item){
				if (!citem.is(item)) $(item).hide();
			});
		},
		error: function(xhr, status, error) { 
			toggleClickabel(clickable); 
			handleError(xhr.status); 
			$($('a.action')).each(function(index, item){
				$(item).show();
			});
		},
		success: function(data){
			var json = JSON.parse(data);
			$('div#assigned').html(json.assigned);
			$('div#unassigned').html(json.unassigned);
		}
	});
};

var doReleaseAs = function(clickable){
	$.ajax({
		url: $(clickable).attr('trigger-href'),
		beforeSend: function(){ toggleClickable(clickable); },
		error: function(xhr, status, error) { toggleClickable(clickable); handleError(xhr.status); },
		success: function(data){
			var json = JSON.parse(data);
			$('div#assigned').html(json.assigned);
			$('div#unassigned').html(json.unassigned);
		}
	});
};

$(document).ready(function(){
	$('#division').change(function(){
		$(this).parents('form').trigger('submit');
	}).select();
	
	$('.w3-bar-item').click(function(){
		$('.w3-bar-item').each(function(index,item){
			$(item).removeClass('w3-blue');
			$($(this).attr('target')).css('display','none');
		});
		$(this).toggleClass('w3-blue');
		$($(this).attr('target')).css('display','block');
	});
});
</script>
@endSection