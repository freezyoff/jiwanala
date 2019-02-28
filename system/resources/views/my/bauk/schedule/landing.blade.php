@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/schedule.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/schedule.subtitles.landing')}}</h4>
	</header>
	<div class="padding-top-8 padding-bottom-16">
		<div class="w3-row w3-container">
			<div class="w3-col s12 m12 l8 schedule padding-right-8">
				<form id="schedule-search" name="schedule-search" action="{{route('my.bauk.schedule.landing')}}" method="post">
					@csrf
					<div class="w3-row">
						<div class="w3-col s12 m6 l6">
							<div class="input-group">
								<label><i class="fas fa-search fa-fw"></i></label>
								<input id="search-keywords" 
									name="keywords"
									class="w3-input ajaxSearch" 
									value=""
									placeholder="{{trans('my/bauk/schedule.hints.searchKeywords')}}" 
									type="text" />
								<input name="active" value="1" type="hidden" />
								<input id="search-nip" name="employee_nip" value="" type="hidden" />
							</div>
						</div>
					</div>
				</form>
				<div class="margin-top-16 padding-bottom-16"></div>
				<form id="schedule-submit" 
					name="schedule-submit" 
					action="{{route('my.bauk.schedule.store')}}" 
					method="post">
					@csrf
					@include('my.bauk.schedule.landing_form')
					<div class="w3-col s12 m12 l12" align="right">
							<button id="btnSubmit" 
								class="w3-button w3-mobile w3-blue w3-hover-blue margin-top-16"
								type="submit"
								onclick="$(this).find('i').removeClass('fa-cloud-upload-alt').addClass('button-icon-loader')">
								<i class="fas fa-cloud-upload-alt fa-fw margin-right-8"></i>
								{{trans('my/bauk/schedule.hints.save')}}
							</button>						
					</div>
				</form>
			</div>
			<div class="w3-col l4 w3-hide-small w3-hide-medium">
				<h6 style="font-weight:600; margin-top:8px;">1. Cari NIP / Nama</h6>
				<p>Buka data dengan mengisi pecarian. Pilih data karyawan yang dikehendaki. Data yang dipilih dimuat NIP dan Nama dibawah.</p>
				<h6 style="font-weight:600; margin-top:8px;">2. Hari & Jam Kerja</h6>
				<p>Centang Hari Kerja sebelum mengisi Jam Masuk dan Jam Pulang. Jam Kerja menggunakan format 24 Jam.</p>
				<h6 style="font-weight:600; margin-top:8px;">3. Simpan</h6>
				<p>Pastikan Hari Kerja dan Jam Kerja sesuai yang anda kehendaki.</p>
				<p>Hari Kerja dicentang <i class="fa-square fa-fw fas w3-hover-text-blue w3-text-blue"></i>, akan disimpan oleh sistem.</p>
				<p>Hari Kerja yang tidak dicentang <i class="fa-square fa-fw far w3-text-blue"></i>, dihapus dari sistem.</p>
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script>
<script src="{{url('js/timepicker.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/timepicker.css')}}">
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('input[type="checkbox"]').click(function(event){ 
		event.stopPropagation(); 
	});
	
	$('.schedule-checkbox').each(function(ind, item){
		$(item).click(function(event){
			$(this).find('i')
				.toggleClass('fas')
				.toggleClass('far')
				.toggleClass('w3-text-blue');
			
			var checkbox = $(this).find('input[type="checkbox"]').trigger('click');
		});
	});
	
	$('#schedule-search').submit(function(){
		$(this).find('i').parent().css('display','');
		return true;
	});
	
	$('input.timepicker').each(function(index, item){
		$(item).timepicker({
			parseFormat: 'HH:mm:ss',
			outputFormat: 'HH:mm:ss'
		});
	});
	
	$('.ajaxSearch').each(function(ind, item){
		$(item).ajaxSearch({
			ajax:{
				type: function(){ return "post"; },
				url:  function(){ return '{{route('my.misc.search.employee')}}'; },
				data: function(){ 
					return $('#schedule-search').serialize(); 
				},
			},
			modal: {
				icon:'{{trans('my/bauk/schedule.modal.searchEmployee.icon')}}',
				title:'{{trans('my/bauk/schedule.modal.searchEmployee.title')}}'
			},
			onFocus: function(){},
			onListItemClicked: function(json){
				$('#search-keywords').val(json.nip);
				$('#search-nip').val(json.nip);
				$('#schedule-search').trigger('submit');
			}
		});
	});
});
</script>
@endSection