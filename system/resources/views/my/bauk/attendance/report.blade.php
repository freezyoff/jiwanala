@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.report')])

@section('dashboard.main')
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>Daftar Laporan</h4>
		</header>
		<div class="w3-row">
			<div class="w3-col s12 m6 l4">
				<div class="input-group">
					<label></label>
				</div>
			</div>
		</div>
		<div class="w3-row w3-container padding-bottom-8">
		
		</div>
	</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script>
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
	
});
</script>
@endSection