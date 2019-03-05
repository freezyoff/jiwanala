@extends('layouts.dashboard.dashboard',['sidebar'=>false])

@section('dashboard.header')
<header class="w3-container" style="padding-top:8px; padding-bottom:8px;">
	<div style="display:flex">
		<h3 style="font-weight:bold;flex-grow:1;">{{\Auth::user()->asEmployee->nip}} {{\Auth::user()->asEmployee->getFullName()}}</h3>
		<div class="input-group periode-container">
			<label><i class="far fa-calendar-check w3-large"></i></label>
			<form action="{{route('my.dashboard.landing')}}" method="post">
				@csrf
				<div class="input-group periode-control w3-text-blue">
					<input id="dashboard-periode-month" 
						name="month"
						value="{{ $month }}"
						type="text" 
						class="w3-input month" 
						role="select"
						select-dropdown="#attendanceProgress-month-dropdown"
						select-modal="#attendanceProgress-month-modal"
						select-modal-container="#attendanceProgress-month-modal-container" />
					<input id="dashboard-periode-year" 
						name="year"
						value="{{ $year }}"
						type="text" 
						class="w3-input" 
						role="select"
						select-dropdown="#attendanceProgress-year-dropdown"
						select-modal="#attendanceProgress-year-modal"
						select-modal-container="#attendanceProgress-year-modal-container" />
				</div>
			</form>
			@include('my.dashboard.landing_month_dropdown')
			@include('my.dashboard.landing_month_modal')
			@include('my.dashboard.landing_year_dropdown')
			@include('my.dashboard.landing_year_modal')
		</div>
	</div>
</header>
@endsection

@section('dashboard.main')
<div class="w3-row">
	@include('my.dashboard.landing_progress')
	@include('my.dashboard.landing_attendance_details')
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
var setProgressBar = function(percentInt, title){
	var duration =  1000,
		percent = percentInt,
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
	
	$('#progressbar-title').html(title);
};

$(document).ready(function(){
	$('input[role="select"]').select({
		style:{
			cursor:'pointer',
			overflow:'visible'
		},
		hideCevron:true
	}).on('change', function(){
		$(this).parents('form').trigger('submit');
	});
	
	setTimeout(function(){
		setProgressBar(parseInt('{{$progress['percent']}}'), '{!!$progress['title']!!}');
	},1500);
});
</script>
@endSection

@section('html.head.styles')
@parent
<style>
.input-group.periode-container{border:none;}
.input-group.periode-control {border:1px solid #ccc; border-radius:4px; text-align:right;  align-items:center;}
.input-group.periode-control>#dashboard-periode-month{width:125px;text-align:center;}
.input-group.periode-control>#dashboard-periode-year{width:50px;text-align:center;}
.input-group.periode-control>#dashboard-periode-month>label,
.input-group.periode-control>#dashboard-periode-year>label{display:none;}

.w3-table>tbody>tr{border-bottom:1px solid #ccc}

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