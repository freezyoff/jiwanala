@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/holiday.title')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>Daftar Hari Libur</h4>
	</header>
	<div class="padding-top-bottom-8">
		<div class="w3-row w3-container">
			<div class="w3-row padding-top-8 padding-bottom-8 w3-hide-medium w3-hide-large">
				<div class="w3-col s12 m3 l3">
					<button class="w3-mobile w3-button w3-blue w3-hover-blue" 
						type="button"
						onclick="$(this).find('i').removeClass('fa-calendar-plus').addClass('button-icon-loader');document.location='{{route('my.bauk.holiday.add')}}'">
						<i class="far fa-calendar-plus fa-fw"></i>
						<span class="padding-left-8">Tambah Hari Libur</span>
					</button>
				</div>
			</div>
			<div class="w3-row padding-top-8 padding-bottom-8">
				<div class="w3-col s12 m4 l3">
					<form name="search" action="{{route('my.bauk.holiday.landing')}}" method="post">
						@csrf
						<div class="input-group padding-left-8 padding-none-small">
							<label><i class="fas fa-calendar"></i></label>
							<input id="year" name="year" type="text" class="w3-input" 
								value="{{now()->format('Y')}}" 
								select-role="dropdown"
								select-dropdown="#year-dropdown" 
								select-modal="#year-modal"
								select-modal-container="#year-modal-container" />
						</div>
					</form>
					<div id="year-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity">
						<ul class="w3-ul w3-hoverable">
							@for($i=now()->format('Y')-4;$i<now()->format('Y')+5;$i++)
							<li style="cursor:pointer;">
								<a class="w3-text-theme w3-mobile" 
									select-role="item" 
									select-value="{{$i}}">
									{{$i}}
								</a>
							</li>
							@endfor
						</ul>
					</div>
					<div id="year-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
						<div class="w3-modal-content w3-animate-top w3-card-4">
							<header class="w3-container w3-theme">
								<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
									onclick="$('#year-modal').hide()" 
									style="font-size:20px !important">
									×
								</span>
								<h4 class="padding-top-8 padding-bottom-8">
									<i class="fas fa-calendar-alt"></i>
									<span style="padding-left:12px;">{{trans('my/bauk/holiday.hints.end')}}</span>
								</h4>
							</header>
							<div id="year-modal-container" class="datepicker-inline-container">
								<div class="w3-bar-block" style="width:100%">
									<ul class="w3-ul w3-hoverable">
										@for($i=now()->format('Y')-4;$i<now()->format('Y')+5;$i++)
										<li style="cursor:pointer;">
											<a class="w3-text-theme w3-mobile" 
												select-role="item" 
												select-value="{{$i}}">
												{{$i}}
											</a>
										</li>
										@endfor
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="w3-col s12 m8 l9 w3-hide-small" style="text-align:right">
					<button class="w3-mobile w3-button w3-blue w3-hover-blue" 
						type="button"
						onclick="$(this).find('i').removeClass('fa-calendar-plus').addClass('button-icon-loader');document.location='{{route('my.bauk.holiday.add')}}'">
						<i class="far fa-calendar-plus fa-fw"></i>
						<span class="padding-left-8">Tambah Hari Libur</span>
					</button>
				</div>
			</div>
		</div>
		<div class="w3-row w3-container">
			<div class="w3-responsive padding-bottom-8">
				@include('my.bauk.holiday.landing_table')
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('[select-role="dropdown"]').select();
});
</script>
@endSection