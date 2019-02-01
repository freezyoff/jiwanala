@extends('layouts.dashboard.dashboard',['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.landing')])

@section('html.head.styles')
@parent
<style>
	/* SMALL */	
	@media only screen and (max-width: 600px) {}
	
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
		<h4>{{trans('my/bauk/attendance/pages.titles.finger')}}</h4>
	</header>
	<div class="w3-row">
		<form id="submitForm" method="post" action="{{ route('my.bauk.attendance.fingers') }}">
			@csrf
			<input name="employee_id" value="{{$employee->id}}" type="hidden" />
			<input name="employee_nip" value="{{$employee->nip}}" type="hidden" />
			<input name="date" value="{{$date->format('Y-m-d')}}" type="hidden" />
			<div class="w3-container padding-top-8">
				<div class="w3-col s12 m6 l3">
					<div class="input-group">
						<label><i class="fas fa-user-circle fa-fw"></i></label>
						<label style="width:100%">{{$employee->nip}}</label>
					</div>
					<label>&nbsp;</label>
				</div>
				<div class="w3-col s12 m6  l3 padding-left-8 padding-none-small">
					<div class="input-group">
						<label><i class="fas fa-font fa-fw"></i></label>
						<label style="width:100%">{{$employee->getFullName()}}</label>
					</div>
					<label>&nbsp;</label>
				</div>
			</div>
			<div class="w3-container">
				<div class="w3-col s12 m6 l3">
					<div class="input-group">
						<label><i class="fas fa-calendar fa-fw"></i></label>
						<label style="width:100%">
							{{trans('calendar.days.long.'.($date->dayOfWeek))}}, &nbsp;
							{{$date->day}}&nbsp;
							{{trans('calendar.months.long.'.($date->month-1))}}&nbsp;
							{{$date->year}}
						</label>
					</div>
					<label>&nbsp;</label>
				</div>
			</div>
			@foreach([1=>'Masuk',2=>'Keluar',3=>'Keluar',4=>'Keluar'] as $item=>$label)
			<div class="w3-container">
				<div class="w3-col s12 m6 l3">
					<div class="input-group">
						<label>
							<i class="fas fa-sign-{{$item>1? 'out' : 'in'}}-alt fa-fw"></i>
						</label>
						<input name="time{{$item}}" 
							value="{{ $attendance? $attendance->{'time'.$item} : "" }}"
							class="timepicker w3-input input" 
							type="text" 
							data-toggle="#time{{$item}}-container"
							readonly="readonly" />
						<label onclick="$(this).prev().val('')" style="cursor:pointer;" class="w3-hover-text-red">
							<i class="fas fa-times fa-fw" style="padding-top:4px"></i>
						</label>
					</div>
					<div class="w3-dropdown-click w3-hide-small" style="display:block">
						<div id="time{{$item}}-container" class="w3-dropdown-content w3-bar-block w3-border"></div>
					</div>
					<label>&nbsp;</label>
				</div>
			</div>
			@endforeach
		</form>
	</div>
	<footer class="w3-container padding-bottom-16 padding-top-16">
		<form action="{{route('my.bauk.attendance.landing')}}" method="post">
			@csrf
			<input name="periode" value="{{$date->format('m-Y')}}" type="hidden" />
			<input name="nip" value="{{$employee->nip}}" type="hidden" />
		</form>
		<button class="w3-button w3-red w3-hover-red" 
			onclick="$(this).find('i').attr('class','w3-red button-icon-loader').css('border-top-color','red'); $(this).prev().submit()"
			type="button">
			<i class="fas fa-times"></i>
			<span class="padding-left-8">Batal</span>
		</button>
		<button class="w3-button w3-blue w3-hover-blue w3-hover-none margin-left-8" 
			onclick="$(this).find('i').attr('class','button-icon-loader'); $('#submitForm').submit()"
			type="button">
			<i class="fas fa-cloud-upload-alt"></i>
			<span class="padding-left-8">Simpan</span>
		</button>
	</footer>
</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script>
<script src="{{url('js/datepicker.js')}}"></script>
<script src="{{url('js/timepicker.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/datepicker.css')}}">
<link rel="stylesheet" href="{{url('css/timepicker.css')}}">
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){ 
	$('input.timepicker').each(function(index, item){
		$(item).timepicker({
			container:$(item).attr('data-toggle'),
			parseFormat: 'HH:mm:ss',
			outputFormat: 'HH:mm:ss'
		});
	});
});
</script>
@endSection4