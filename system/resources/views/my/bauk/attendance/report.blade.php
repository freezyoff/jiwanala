@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.report')])

@section('dashboard.main')
<div class="w3-col s12 m6 l6">
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans('my/bauk/attendance/pages.subtitles.report_monthly')}}</h4>
		</header>
		<div class="w3-container">
			<div class="w3-col s12 m12 l12">
				<div class="w3-row padding-bottom-8">
					@include('my.bauk.attendance.report.monthly_form')
					@include('my.bauk.attendance.report.monthly_statistics')
				</div>
				<div class="w3-row padding-top-8 padding-bottom-16" style="text-align:right">
					<button class="w3-button w3-mobile w3-blue w3-hover-blue" 
						onclick="$('#monthly-form').trigger('submit');">
							<i class="fas fa-cloud-download-alt"></i>
							<span class="padding-left-8">Unduh</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small margin-top-16 margin-none-medium">
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans('my/bauk/attendance/pages.subtitles.report_summary')}}</h4>
		</header>
		<div class="w3-container">
			<div class="w3-col s12 m12 l12">
				<div class="w3-row padding-bottom-8">
					@include('my.bauk.attendance.report.summary_form')
					@include('my.bauk.attendance.report.summary_statistics')
				</div>
				<div class="w3-row padding-top-8 padding-bottom-16" style="text-align:right">
					<button class="w3-button w3-mobile w3-blue w3-hover-blue" 
						onclick="$('#summary-form').trigger('submit');">
							<i class="fas fa-cloud-download-alt"></i>
							<span class="padding-left-8">Unduh</span>
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('input[role="select"]').select();
	attendanceProgress.init();
	attendanceSummary.init();
});
</script>
@endSection