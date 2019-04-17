@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.landing')])

@section('dashboard.main')
	<div class="w3-card">
		<!--
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>Riwayat Kehadiran</h4>
		</header>
		-->
		<div id="tabs-header" class="w3-row w3-container w3-theme">
			<button class="w3-bar-item w3-button w3-large margin-top-8 w3-hover-blue" 
					onclick="App.UI.tabs.higlightHeader(this); App.UI.tabs.showItem('#employee')">
				Karyawan
			</button>
			<button class="w3-bar-item w3-button w3-large margin-top-8 w3-hover-blue" 
					onclick="App.UI.tabs.higlightHeader(this); App.UI.tabs.showItem('#monthly')">
				Bulanan
			</button>
			<button class="w3-bar-item w3-button w3-large margin-top-8 w3-hover-blue" 
					onclick="App.UI.tabs.higlightHeader(this); App.UI.tabs.showItem('#summary')">
				Rekapitulasi
			</button>
		</div>
		<div id="tabs-container" class="w3-row w3-container padding-bottom-8">
			<div id="employee" class="{{isset($tabs) && $tabs == 'employee'? '' : 'w3-hide'}}">
				@include('my.bauk.attendance.landing.employee_form')
				@include('my.bauk.attendance.landing.employee_table')
			</div>
			<div id="monthly" class="city {{isset($tabs) && $tabs == 'monthly'? '' : 'w3-hide'}}">
				<h2>Monthly</h2>
				<p>Tokyo is the capital of Japan.</p>
			</div>
			<div id="summary" class="city {{isset($tabs) && $tabs == 'summary'? '' : 'w3-hide'}}">
				<h2>Tokyo</h2>
				<p>Tokyo is the capital of Japan.</p>
			</div>
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
App.UI.tabs = {
	showItem: function(id){
		$('#tabs-container').children().addClass('w3-hide');
		$(id).removeClass('w3-hide');
	},
	higlightHeader: function(el){
		$('#tabs-header').children().removeClass('w3-light-grey');
		$(el).addClass('w3-light-grey');
	},
	init: function(){
		this.higlightHeader($('#tabs-header').children().first());
	}
};
</script>
<script>
$(document).ready(function(){ 
	App.UI.tabs.init();
});
</script>
@endSection