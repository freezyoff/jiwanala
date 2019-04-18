@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.landing')])

@section('dashboard.main')
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8">
			<h4>Riwayat Karyawan</h4>
		</header>
		<div id="tabs-header" class="w3-row w3-theme padding-left-8">
			<button id="tab-item-summary" class="w3-bar-item w3-button margin-top-8" 
					onclick="App.UI.tabs.higlightHeader(this); App.UI.tabs.showItem('#summary')">
				Rekapitulasi
			</button>
			<button id="tab-item-details" class="w3-bar-item w3-button margin-top-8" 
					onclick="App.UI.tabs.higlightHeader(this); App.UI.tabs.showItem('#details')">
				Detil
			</button>
		</div>
		<div class="w3-container padding-top-8">
			@include('my.bauk.attendance.landing.search_nip_form')
			@include('my.bauk.attendance.landing.search_history_form')
		</div>
		<div id="tabs-container" class="w3-row w3-container padding-bottom-8">
			<div id="summary" class="{{isset($tabs) && $tabs == 'summary'? '' : 'w3-hide'}}">
				@include('my.bauk.attendance.landing.summary_table')
			</div>
			<div id="details" class="{{isset($tabs) && $tabs == 'details'? '' : 'w3-hide'}}">
				@include('my.bauk.attendance.landing.details_form')
				@include('my.bauk.attendance.landing.details_table')
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
<style>
.w3-table-all tbody tr td .w3-row + .w3-row{ margin-top:8px; margin-bottom:8px; }
.w3-table-all tbody tr td .w3-row + .w3-row.w3-tag{ margin:0; }
</style>
@endSection

@section('html.body.scripts')
	@parent
	@include('my.bauk.attendance.landing.js')
@endSection