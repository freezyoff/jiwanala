@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/holiday.title')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/holiday.subtitles.add')}}</h4>
	</header>
	<div class="w3-row padding-top-bottom-8">
		<div class="w3-col s12 m12 l6">
			<form name="add" method="post" action="{{route('my.bauk.holiday.edit',[$holiday->id])}}">
				@include('my.bauk.holiday.edit_form')			
			</form>
		</div>
		<div class="w3-col s12 m12 l6 w3-hide-small w3-hide-medium">
			@foreach(trans('my/bauk/holiday.info') as $key=>$item)
			<h6 style="padding-top:{{$key>0? '.5':'.3' }}em; font-size:1.1em"><strong>{{$item['h6']}}</strong></h6>
			<p style="font-size:1em">{{$item['p']}}</p>
			@endforeach
		</div>
	</div>
</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('js/datepicker.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/datepicker.css')}}">
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('[select-role="dropdown"]').select();
	
	var datepickerModal = {format: 'dd-mm-yyyy', offset: 5, container: '', inline: true, language: 'id-ID'};
	$('[datepicker-role="modal"]').each(function(){
		var input = $(this);
		var datepickerValue = $(input.attr('datepicker-value'));

			
		datepickerValue.on('datepicker.update', function(){
			input.val($(this).val());
		});
		
		input.datepicker( $.extend(datepickerModal, {container: input.attr('datepicker-container') }) )
			.on('click focusin', function(event){
				event.stopPropagation();
				$( $(this).attr('datepicker-modal') ).show();
			})
			.on('pick.datepicker', function(){
				datepickerValue.val($(this).datepicker('getDate',true)).trigger('datepicker.update');
				$( $(this).attr('datepicker-modal') ).hide();
				$($(this).attr('datepicker-link')).datepicker('hide');
			});
			
		$(window).resize(function(){
			$( input.attr('datepicker-modal') ).hide();
		});
	});
	
	var datepickerFloat = {format: 'dd-mm-yyyy', offset: 5, autoHide:true, language: 'id-ID'};
	$('[datepicker-role="dropdown"]').each(function(){
		var input = $(this);
		var datepickerValue = $(input.attr('datepicker-value'));
		
		datepickerValue.on('datepicker.update', function(){
			input.val($(this).val());
		});
		
		input.datepicker(datepickerFloat)
			.on('click focusin', function(event){
				event.stopPropagation();
				$($(this).attr('datepicker-link')).trigger('click');
			})
			.on('pick.datepicker', function(){
				datepickerValue.val($(this).datepicker('getDate',true)).trigger('datepicker.update');
			});
			
		$(window).resize(function(){
			input.datepicker('hide');
		});
	});
	
	$('#startsmall, #startlarge').on('pick.datepicker',function(){
		var xx = $(this).datepicker('getDate');
		var yy = $('#endsmall').datepicker('getDate');
		var rr = null;
		if (xx < yy) rr = yy; else if (xx > yy) rr = xx; else rr = xx;	
		$('#endsmall, #endlarge').datepicker('setDate', rr).datepicker('setStartDate', xx);
	});
	
	var init = $('input[name="start"]').val();
	if (init != ''){
		$('#startsmall, #startlarge').datepicker('update').trigger('pick.datepicker');		
	}
});
</script>
@endSection