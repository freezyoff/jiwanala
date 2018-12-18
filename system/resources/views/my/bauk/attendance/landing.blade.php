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
			<h4>Riwayat Kehadiran</h4>
		</header>
		<div class="w3-row">
			<form id="searchNipOrName" action="{{route('my.bauk.attendance.search.employee')}}" method="post">
				@csrf
			<div class="w3-container padding-top-8">
					<div class="w3-col s12 m4 l6">
						<div class="input-group">
							<label>
								<i class="fas fa-user-circle fa-fw"></i>
							</label>
							<input name="keywords" class="w3-input input" type="text" placeholder="NIP" autocomplete="off" />
						</div>
						<label>&nbsp;</label>
						<div class="w3-dropdown-click w3-hide-small" style="display:block">
							<div id="searchNipOrName-dropdown" 
								class="w3-card w3-dropdown-content w3-bar-block w3-border" 
								style="width:100%; max-height:400px; overflow:hidden scroll;">
								<ul style="display:table; list-style:none; width:100%"></ul>
							</div>
						</div>
					</div>
					<div class="w3-col s12 m8 l6 padding-left-8 padding-none-small">
						<input name="periode" type="hidden" />
						<div class="input-group">
							<label>
								<i class="fas fa-calendar fa-fw"></i>
							</label>
							<input name="periode[large]" 
								value=""
								data-toggle="datepicker-dropdown"
								data-value="input[name='periode']"
								class="w3-input input w3-hide-small w3-hide-medium" 
								type="text" 
								placeholder="Bulan" />
							<input name="periode[small]" 
								value=""
								data-toggle="datepicker-modal"
								data-modal="#periode-datepicker-modal"
								data-modal-container="#periode-datepicker-modal-container"
								data-value="input[name='periode']"
								class="w3-input input w3-hide-large" 
								type="text" 
								placeholder="Bulan" />
						</div>
						<label>&nbsp;</label>
						<div id="periode-datepicker-modal" class="w3-modal w3-display-container datepicker-modal" onclick="$(this).hide()">
							<div class="w3-modal-content w3-animate-top w3-card-4">
								<header class="w3-container w3-theme">
									<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
										onclick="$(parent('.w3-modal')).hide()" 
										style="font-size:20px !important">
										×
									</span>
									<h4 class="padding-top-8 padding-bottom-8">
										<i class="fas fa-calendar-alt"></i>
										<span style="padding-left:12px;">Calendar</span>
									</h4>
								</header>
								<div id="periode-datepicker-modal-container" class="datepicker-inline-container"></div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="w3-row w3-container">
			<table class="w3-table">
				<thead>
					<tr class="w3-theme-l1">
						<th>Hari & Tanggal</th>
						<th>Izin / Hadir</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						if (isset($periode)){
							$carbonDate = \Carbon\Carbon::createFromFormat('d-m-Y', preg_replace('/\s+/','01-'.$periode));
						}
						else{
							$carbonDate = now();
							$carbonDate->day = 1;
						}
						$days = trans('calendar.days.long');
					?>
					@for($i=0;$i<$carbonDate->daysInMonth;$i++,$carbonDate->addDay())
						<tr>
							<th>
								<span style="width:60px;display:inline-block">{{$days[$carbonDate->dayOfWeek]}},</span> 
								<span class="padding-left-8">{{strlen($i+1)==2? ($i+1) : '0'.($i+1)}}</span>
							</th>
							<th>Izin / Hadir</th>
						</tr>
					@endfor
				</tbody>
			</table>
			<div></div>
		</div>
	</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('vendors/cowboy/jquery-throttle-debounce.js')}}"></script>
<script src="{{url('js/datepicker.js')}}"></script>
{{-- <script src="{{url('js/timepicker.js')}}"></script> --}}
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/datepicker.css')}}">
{{-- <link rel="stylesheet" href="{{url('css/timepicker.css')}}"> --}}
@endSection

@section('html.body.scripts')
@parent
<script>
App.UI.search = {
	init:function(){
		App.UI.search.form.init();
		App.UI.search.text.init();
		App.UI.search.date.init();
	}
};

App.UI.search.form = {
	container: $('#searchNipOrName'),	
	submit: function (event) {
		event.preventDefault();
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			beforeSend: App.UI.search.text.dropdown.onAjaxSend,
			complete: App.UI.search.text.dropdown.onAjaxComplete,
			success: App.UI.search.text.dropdown.onAjaxSuccess,
			error: App.UI.search.text.dropdown.onAjaxFailed,
		});
	},
	init:function(){
		App.UI.search.form.container.submit(App.UI.search.form.submit);
	}
};
App.UI.search.text = {
	container: App.UI.search.form.container.find('input[name="keywords"]'),
	value: function(value){ $(this.container).val(value); },
	init:function(){
		$('#searchNipOrName').find('input[name="keywords"]')
			.on('keyup', $.debounce(250, function(e){
				if (e.keyCode == 27 || e.keyCode == 38) { //escape & up arrow
					App.UI.search.text.dropdown.hide();
				}
				else if (e.keyCode == 40){	//down arrow
					App.UI.search.text.dropdown.show();
				}
				else {
					$('#searchNipOrName').submit();				
				}
			}));
	}
};

App.UI.search.text.dropdown = {
	container: $('#searchNipOrName-dropdown>ul'),
	empty: function(){ App.UI.search.text.dropdown.container.empty(); },
	dropdown: function(){
		$(window).resize(App.UI.search.text.dropdown.onWindowResize);
	},
	itemClicked: function(){
		App.UI.search.text.value($(this).find('div.nip').html());
		App.UI.search.text.dropdown.hide();
	},
	onHoverIn: function(){
		$(this).css('background-color', '#222');
	},
	onHoverOut: function(){
		$(this).css('background-color', 'transparent');
	},
	onAjaxSend: function(){
		$('#searchNipOrName').find('.input-group>input[name="keywords"]').prev().children()
			.removeClass('fa-user-circle').addClass('button-icon-loader');
	},
	onAjaxComplete: function(){
		$('#searchNipOrName').find('.input-group>input[name="keywords"]').prev().children()
			.removeClass('button-icon-loader').addClass('fa-user-circle');
	},
	onAjaxSuccess: function (data) {
		App.UI.search.text.dropdown.empty();
		$.each(data, function(index, item){ 
			App.UI.search.text.dropdown.addItems(item);
		});
		App.UI.search.text.dropdown.show();
	},
	onAjaxFailed: function (data) {
		$('#searchNipOrName-dropdown').hide();
	},
	createItem: function(json){
		var name = json.name_front_titles==null? '': json.name_front_titles;
			name += json.name_full==null? '' : ' ' + json.name_full;
			name += json.name_back_titles==null? '' : ' ' + json.name_back_titles;
		var li = $('<li style="display:table-row; cursor:pointer"></li>').hover(App.UI.search.text.dropdown.onHoverIn, App.UI.search.text.dropdown.onHoverOut);
			li.append($('<div class="nip" style="display:table-cell; padding:8px 16px; width:100px;">'+ json.nip +'</div>'));
			li.append($('<div class="name" style="display:table-cell; padding:8px 16px; white-space: nowrap;">'+ name +'</div>'));
		return li.click(App.UI.search.text.dropdown.itemClicked);
	},
	addItems: function(item){ 
		var li = App.UI.search.text.dropdown.createItem(item);
		App.UI.search.text.dropdown.container.append( li ); 
	},
	onWindowResize: function(){
		App.UI.search.text.dropdown.container.parent().css('visiblity','hidden').show();
		var listWidth = App.UI.search.text.dropdown.container.width() + 25;
		var containerWidth = App.UI.search.text.dropdown.container.parent().width();
		App.UI.search.text.dropdown.container.parent().width( Math.max(listWidth, containerWidth) );
		App.UI.search.text.dropdown.container.parent().css('visiblity','visibel').hide();
	},
	show: function(){ 
		var list = App.UI.search.text.dropdown.container.find('li');
		if (list.length>0){ 
			App.UI.search.text.dropdown.container.parent().css('visiblity','hidden').show();
		}
		else{ App.UI.search.text.dropdown.hide(); }
	},
	hide: function(){ 
		App.UI.search.text.dropdown.container.parent().hide(); 
	}
};

App.UI.search.date = {
	options: {
		float:{ format: 'mm - yyyy', offset: 5, language: 'id-ID', autoHide:true },
		inline: { format: 'mm - yyyy', offset: 5, container: '', inline: true, language: 'id-ID'}
	},
	events:{
		pick: function(e){
			$( $(this).attr('data-value') ).val( $(this).datepicker('getDate',true) );
			
			var val = $(this).datepicker('getMonthName') + '-' + $(this).datepicker('getYear');
			$(this).attr('value','asdasds');
		},
		showModal: function(){
			$(this).val( $($(this).attr('data-value')).val() );
			$($(this).attr('data-modal')).show();
		},
		hideModal: function(){
			$($(this).attr('data-modal')).hide();
		},
		syncChange: function(){}
	},
	init:function(){
		$('[data-toggle="datepicker-dropdown"]').datepicker(App.UI.search.date.options.float)
			.on('pick.datepicker', App.UI.search.date.events.pick);
		$('[data-toggle="datepicker-modal"]').each(function(){
			$(this).datepicker(
				$.extend(App.UI.search.date.options.inline,{container: $(this).attr('data-modal-container')})
				).on('pick.datepicker', App.UI.search.date.events.pick)
				.on('pick.datepicker', App.UI.search.date.events.hideModal)
				.on('focusin', App.UI.search.date.events.showModal);
		});
	}
};
</script>
<script>
$(document).ready(function(){ App.UI.search.init(); });
</script>
@endSection