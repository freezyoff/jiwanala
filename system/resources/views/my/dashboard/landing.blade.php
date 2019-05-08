@extends('layouts.dashboard.dashboard',['sidebar'=>false,'title'=>'Dashboard'])

@section('dashboard.main')
<div class="w3-row">
	<form action="{{route('my.dashboard.landing')}}" method="post">
		@csrf
		<div class="w3-col s12 m12 l4">
			<div class="w3-teal w3-text-white"
				style="border:1px solid #ccc; border-radius:4px; padding:8px; display:flex;">
				<div style="font-size:2em; padding:0 8px;">
					<i class="fas fa-user"></i>
				</div>
				<div class="margin-left-8">
					<div>{{$nip}}</div>
					<div>{{$employee->getFullName()}}</div>
				</div>
			</div>
		</div>
		<div class="padding-left-16 w3-col s12 m12 l8 padding-none-small">
			<div class="w3-col s12 m6 l4">
				<div class="input-group padding-top-8">
					<label><i class="far fa-calendar-check w3-large"></i></label>
					<input id="dashboard-periode-month" 
						name="month"
						value="{{ $month }}"
						type="text" 
						class="w3-input month" 
						role="select"
						select-dropdown="#attendanceProgress-month-dropdown"
						select-modal="#attendanceProgress-month-modal"
						select-modal-container="#attendanceProgress-month-modal-container" />
				</div>
			</div>
			<div class="w3-col s12 m6 l4">
				<div class="input-group margin-left-8 margin-none-small padding-top-8">
					<label><i class="far fa-calendar-check w3-large"></i></label>
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
				@include('my.dashboard.landing_month_dropdown')
				@include('my.dashboard.landing_month_modal')
				@include('my.dashboard.landing_year_dropdown')
				@include('my.dashboard.landing_year_modal')
			</div>
		</div>
	</form>
</div>
<div class="w3-row">
	<div id="attendanceProgress" class="w3-col s12 m12 l4 w3-light-grey">
		<div class="padding-top-16 padding-bottom-16 margin-right-16 margin-none-small margin-none-medium">
			<div class="w3-col s12 m12 l12 margin-bottom-8" style="min-width:135px">
				<div style="display:flex;align-items:center;justify-content:space-evenly;min-width:275px">
					@include('my.dashboard.landing_radial_progressbar')
				</div>
			</div>
			<div id="attendanceProgress-tabs" 
				class="w3-bar w3-black w3-hide-large" 
				style="padding:8px 8px 0 8px">
				<button class="w3-bar-item w3-button" toggle="#attendanceProgress-summary">
					<h6>Rekapitulasi</h6>
				</button>
				<button class="w3-bar-item w3-button" toggle="#attendanceProgress-details">
					<h6>Detil Bulan ini</h6>
				</button>
			</div> 
			<div id="attendanceProgress-summary" class="w3-col s12 m12 l12 padding-left-8 padding-none-small padding-none-medium padding-none-large">
				@include('my.dashboard.landing_attendance_summary')
			</div>
		</div>
	</div>
	<div id="attendanceProgress-details" class="w3-col s12 m12 l8 margin-top-16 margin-none-large padding-left-16-large">
		@include('my.dashboard.landing_attendance_details')
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
var setProgressBar = function(id, percentInt, title){
	var duration =  1000,
		percent = percentInt,
		angel = (percent/100)*360,
		pbar = $('#'+id),
		span = $('#'+id+'-label'),
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
	
	$('#'+id+'-title').html(title);
};

var tabs = {
	tabs: '#attendanceProgress-tabs',
	containers: ['#attendanceProgress-summary', '#attendanceProgress-details'],
	onTabChange: function(){
		tabs.highlightButton(this, false);
		tabs.hide($(this).attr('toggle'));
	},
	onTabClick: function(){
		$(tabs.tabs).children().trigger('change');
		tabs.highlightButton(this, true);
		tabs.show($(this).attr('toggle'));
	},
	highlightButton: function(button, flag){
		if (flag){ 	$(button).addClass('w3-light-grey'); }
		else{ 		$(button).removeClass('w3-light-grey'); }
	},
	isVisible: function(){
		return $(tabs.tabs).css('display')!='none';
	},
	show: function(element){
		$(element).show();
	},
	hide: function(element){
		$(element).hide();
	},
	onResize: function(){
		if (tabs.isVisible()){
			tabs.hideAll();
			$('#attendanceProgress > div').removeClass('padding-bottom-16');
			$('#attendanceProgress-details').removeClass('margin-top-16');
			$(tabs.tabs).children().first().trigger('click');
		}
		else{
			$('#attendanceProgress > div').addClass('padding-bottom-16');
			$('#attendanceProgress-details').addClass('margin-top-16');
			tabs.showAll();
		}
	},
	init: function(){
		//install tab listener
		$(tabs.tabs).children().on({
			change: tabs.onTabChange,
			click: tabs.onTabClick
		});
		
		//$(window).on('resize', function(){
		//	tabs.onResize();
		//});
		tabs.onResize();
	},
	showAll:function(){
		$.each(tabs.containers, function(index,item){
			tabs.show(item);
		});
	},
	hideAll: function(){
		$.each(tabs.containers, function(index,item){
			tabs.hide(item);
		});
	},
};

$(document).ready(function(){
	$('input[role="select"]').select({
		style:{
			cursor:'pointer',
			overflow:'visible'
		}
	}).on('change', function(){
		$(this).parents('form').trigger('submit');
	});
	
	setTimeout(function(){
		setProgressBar('current-progress', parseInt('{{$summary['rows']['thisMonth']->get('attendance')}}'), '{!!'Bulan Ini<br>('.$summary['tableHeaders'][1].')'!!}');
		setProgressBar('workyear-progress', parseInt('{{$summary['rows']['tillThisMonth']->get('attendance')}}'), '{!!'Sampai Bulan ini<br>('.$summary['tableHeaders'][2].')'!!}');
	},1500);
	
	tabs.init();
});
</script>
@endSection

@section('html.head.styles')
@parent
<style>
.input-group.periode-container{border:1px solid #ccc; border-radius:4px; text-align:right; max-width:175px; align-items:center; justify-content:center}
.input-group.periode-control {border:none; align-items:center;}
.input-group.periode-control>#dashboard-periode-month{width:125px;text-align:center;}
.input-group.periode-control>#dashboard-periode-year{width:50px;text-align:center;}
.input-group.periode-control>#dashboard-periode-month>label,
.input-group.periode-control>#dashboard-periode-year>label{display:none;}

.w3-table>tbody>tr{border-bottom:1px solid #ccc}

.w3-table-all tbody tr td .w3-row + .w3-row{ margin-top:8px; margin-bottom:8px; }
.w3-table-all tbody tr td .w3-row + .w3-row.w3-tag{ margin:0; }
</style>
@endSection