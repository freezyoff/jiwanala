@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/landing.page.title')])

@section('html.head.styles')
@parent
<style>
	/* SMALL */	
	@media only screen and (max-width: 600px) {		
	}
	
	@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
	@media only screen and (min-width: 768px){			/* Medium devices (landscape tablets, 768px and up) */
	}
	
	@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
	@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
	}
</style>
@endSection

@section('dashboard.main')
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>Izin Kehadiran</h4>
		</header>
		<div class="w3-container">
			<div class="w3-row">
				<div class="w3-col s12 m12 l8">
					<input name="nip" class="w3-input" type="text" placeholder="NIP" />
				</div>
			</div>
		</div>
	</div>
	<div class="w3-card" style="margin-top:32px;">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>Upload Kehadiran</h4>
		</header>
	</div>
@endSection

@section('html.head.scripts')
@parent
{{-- <script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script> --}}
{{-- <script src="{{url('js/datepicker.js')}}"></script> --}}
{{-- <script src="{{url('js/timepicker.js')}}"></script> --}}
@endSection

@section('html.head.styles')
@parent
{{-- <link rel="stylesheet" href="{{url('css/datepicker.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{url('css/timepicker.css')}}"> --}}
@endSection

@section('html.body.scripts')
@parent
<script>
	
</script>
@endSection