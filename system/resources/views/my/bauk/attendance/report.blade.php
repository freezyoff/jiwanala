@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.report')])

@section('dashboard.main')
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans('my/bauk/attendance/pages.subtitles.report')}}</h4>
		</header>
		<div class="w3-container">
			<div class="w3-col s12 m12 l8">
				<div class="w3-row">
					@include('my.bauk.attendance.report_form')
				</div>
				<div class="w3-row padding-bottom-8">
					@include('my.bauk.attendance.report_statistics')
				</div>
				<div class="w3-row padding-top-8 padding-bottom-16" style="text-align:right">
					<button class="w3-button w3-mobile w3-blue w3-hover-blue" 
						onclick="$('#report-form').trigger('submit');">
							<i class="fas fa-cloud-download-alt"></i>
							<span class="padding-left-8">Unduh</span>
					</button>
				</div>
			</div>
		</div>
	</div>
@endSection

@section('html.body.scripts')
@parent
<script>
var attendanceProgress = {
	init: function(){
		$('#attendanceProgress-year, #attendanceProgress-month').on('select.pick', function(event, oldValue, newValue){
			if (oldValue != newValue){
				attendanceProgress.send();	
			}
		});
		attendanceProgress.send();
		employeesCount();
	},
	send: function(){
		$.ajax({
			method: "POST",
			url: '{{route('my.bauk.landing.info.attendanceProgress')}}',
			data: { 
				'_token': '{{csrf_token()}}',
				'year': $('#attendanceProgress-year').val(),
				'month': $('#attendanceProgress-month').val(),
			},
			dataType: "json",
			beforeSend: function() {
				$('#progressbar-radial-label').html($('<i class="button-icon-loader"></i>'));
			},
			success: function(response){
				attendanceProgress.setProgressbar(response.percent);
				$('#progressbar-title').html(response.title);
				$('#empoyee-consents').html(response.consents);
				$('#empoyee-lateArrivalOrEarlyDeparture').html(response.lateArrivalOrEarlyDeparture);
				$("#employee-noLateOrEarlyDocs").html(response.noLateOrEarlyDocs);
				$("#employee-noConsentDocs").html(response.noConsentDocs);
			}
		});
	},
	setProgressbar: function(percent){
		var duration =  1000,
			percent = percent,
			angel = (percent/100)*360,
			pbar = $('#progressbar-radial'),
			span = $('#progressbar-radial-label'),
			slice = pbar.find('.slice'),
			startAngel = parseInt(pbar.attr('angel')),
			startCount = parseInt(pbar.attr('percent'));
			
		$({countNum: isNaN(startAngel)? 0 : startAngel, deg: isNaN(startCount)? 0 : startCount}).animate({countNum: percent, deg: angel}, {
			duration: duration,
			easing:'linear',
			step: function() {
				span.html(Math.floor(this.countNum)+'%');
				slice.find('.bar').css('transform','rotate('+ this.deg +'deg)');
				
				if (this.deg>180){
					slice.addClass('full');
					slice.find('.fill').css('transform','rotate(180deg)');
				} 
				else{
					slice.removeClass('full');
					slice.find('.fill').css('transform','rotate('+ this.deg +'deg)');
				}
				pbar.attr('angel',angel);
				pbar.attr('percent',this.countNum);
			}
		});
	}
};

$(document).ready(function(){
	$('input[role="select"]').select();
	attendanceProgress.init();
});
</script>
@endSection

@section('html.head.styles')
@parent
<style>
.progressbar.radial *{box-sizing:content-box;}
.progressbar.radial{
	position: relative;
	font-size: 120px;
	width: 1em;
	height: 1em;
	border-radius: 50%;
	background-color: #cccccc;
}

.progressbar.radial:after{
	position: absolute;
	top: 0.08em;
	left: 0.08em;
	display: block;
	content: " ";
	border-radius: 50%;
	background-color: #f5f5f5;
	width: 0.84em;
	height: 0.84em;
	-webkit-transition-property: all;
	-moz-transition-property: all;
	-o-transition-property: all;
	transition-property: all;
	-webkit-transition-duration: 0.2s;
	-moz-transition-duration: 0.2s;
	-o-transition-duration: 0.2s;
	transition-duration: 0.2s;
	-webkit-transition-timing-function: ease-in;
	-moz-transition-timing-function: ease-in;
	-o-transition-timing-function: ease-in;
	transition-timing-function: ease-in;
}

.progressbar.radial span{
	position: absolute;
	width: 100%;
	z-index: 1;
	left: 0;
	top: 0;
	width: 5em;
	line-height: 5em;
	font-size: 0.2em;
	color: #307bbb;
	display: block;
	text-align: center;
	white-space: nowrap;
	-webkit-transition-property: all;
	-moz-transition-property: all;
	-o-transition-property: all;
	transition-property: all;
	-webkit-transition-duration: 0.2s;
	-moz-transition-duration: 0.2s;
	-o-transition-duration: 0.2s;
	transition-duration: 0.2s;
	-webkit-transition-timing-function: ease-out;
	-moz-transition-timing-function: ease-out;
	-o-transition-timing-function: ease-out;
	transition-timing-function: ease-out;
}


.progressbar.radial .slice .bar,
.progressbar.radial .slice .fill{
	position: absolute;
	border: 0.08em solid #307bbb;
	width: 0.84em;
	height: 0.84em;
	clip: rect(0em, 0.5em, 1em, 0em);
	border-radius: 50%;
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
}

.progressbar.radial .slice{position: absolute;width: 1em;height: 1em;clip: rect(0em, 1em, 1em, 0.5em);}
.progressbar.radial .slice.full{clip: rect(auto, auto, auto, auto) !important;}
</style>
@endSection