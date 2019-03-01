@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.finger')}}</h4>
	</header>
	<div class="w3-row">
		<div class="w3-col s12 m12 l7 padding-top-16 padding-bottom-16">
			@include('my.bauk.attendance.finger_history_form')
		</div>
		<div class="w3-col s12 m12 l5 w3-hide-small w3-hide-medium padding-top-8">
			@foreach(trans('my/bauk/attendance/hints.info.finger') as $key=>$item)
			<h6 style="padding-top:{{$key>0? '.5':'.3' }}em; font-size:1.1em"><strong>{{$item['h6']}}</strong></h6>
			<p style="font-size:1em">{!! $item['p'] !!}</p>
			@endforeach
		</div>
	</div>
</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/timepicker.css')}}">
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){ 
	$('input.timepicker').each(function(index, item){
		$(item).timepicker({
			parseFormat: 'HH:mm:ss',
			outputFormat: 'HH:mm:ss'
		});
	});
});
</script>
@endSection