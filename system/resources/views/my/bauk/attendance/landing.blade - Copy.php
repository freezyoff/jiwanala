@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/landing.page.title')])

@section('html.head.styles')
@parent
<style>
	/* SMALL */
	@media only screen and (max-width: 600px) {		
		#small {min-width:300px;}
		#small .btn-upload{
			display:inline-block; 
			border-radius:100%; 
			width:100px; 
			height:100px; 
			text-align:center; 
			vertical-align:middle;
			position:relative;
			background-color:#008DFF;
			color:#FCFCFC;
			line-height:2.8;
		}
		
		.input-group input {min-width:100px;}
		
		i.loader {
		  border: 16px solid #FCFCFC;
		  border-top: 16px solid #008DFF;
		  border-radius: 50%;
		  width: 100px;
		  height: 100px;
		  position:relative;
		  left:25%;
		  animation: spin 2s linear infinite;
		}
	}
	
	@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
	@media only screen and (min-width: 768px){			/* Medium devices (landscape tablets, 768px and up) */
		#medium {min-width:300px;}
	}
	
	@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
	@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
	}
</style>
@endSection

@section('dashboard.main')
{{base_path()}}
	@include('my.bauk.attendance.landing_first')
	
	@include('my.bauk.attendance.landing_second')
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
	App.UI.small = {
		init: function(){
			$('#inpUpload').change(function(){
				$('#small>label').addClass('w3-hide')
					.next().removeClass('w3-hide');
			})
		},
		
	};
	
	App.UI.upload = {
		init: function(){
			$('#inpUpload').change(App.UI.upload.doUpload);
		},
		doUpload: function(){
			$('#fmUpload').submit();
		}
	};
	
	App.UI.datepicker = {
		format: {
			float:{ format: 'dd-mm-yyyy', offset: 5, language: 'id-ID', autoHide:true },
			inline: { format: 'dd-mm-yyyy', offset: 5, container: '', inline: true, language: 'id-ID'}
		},
		click:{
			float: function(e){
				if(e.view == 'day') {
					var td = $(e.target).datepicker('getDate');
				}
				$(e.target).trigger('value-change');
			},
			inline:function(e){
				if(e.view == 'day') {
					var modal = $(e.target).attr('data-modal');
					$(modal).hide();
					App.UI.datepicker.click.float(e);
				}
			},
		},
		showModal: function(e){
			var modal = $(this).attr('data-modal');
			$(modal).show();
		},
		valueChange: function(e){
			var taget = $(e.target).attr('data-value');
			$(taget).val($(e.target).val());
		},
		init: function(){
			$('[data-toggle="datepicker-modal"]').each(function(){
				var opt = $.extend(App.UI.datepicker.format.inline, {container: $(this).attr('data-container')});
				$(this).datepicker(opt)
					.on('focusin', App.UI.datepicker.showModal)
					.on('pick.datepicker', App.UI.datepicker.click.inline)
					.on('value-change change keyup', App.UI.datepicker.valueChange);
			});	
			$('[data-toggle="datepicker"]').each(function(){
				$(this).datepicker(App.UI.datepicker.format.float)
					.on('focusin', App.UI.datepicker.showModal)
					.on('pick.datepicker', App.UI.datepicker.click.inline)
					.on('value-change change keyup', App.UI.datepicker.valueChange);
			});	
		}
	};
	
	$(document).ready(function(){
		App.UI.upload.init();
		App.UI.small.init();
		App.UI.datepicker.init();
		
		App.Large.init();
		$(window).keydown(function(event){
			if(event.keyCode == 13) {
				event.preventDefault();
				return false;
			}
		});
	});
	
	App.Large = {
		init: function(){
			App.Large.datepicker();
			App.Large.timepicker();
			
			$(window).click(function(){
				console.log('window.click');
				App.Large.closeFloatingInput();
			});
		},
		closeFloatingInput: function(){
			$('form#large input[data-toggle="timepicker"]').trigger('hide');
			$('form#large input[data-toggle="datepicker"]').datepicker('hide');
		},
		datepicker: function(){
			$('form#large input[data-toggle="datepicker"]').each(function(index,item){
				$(item).datepicker(App.UI.datepicker.format.float)
					.on('click focus', function(event){ 
						event.stopPropagation(); 
						App.Large.closeFloatingInput();
						$(this).datepicker('show');
					})
					.on('pick.datepicker', App.UI.datepicker.click.inline)
					.on('value-change change keyup', App.UI.datepicker.valueChange);
			});	
		},
		timepicker:function(){
			$('form#large input[data-toggle="timepicker"]').each(function(){
				$(this).timepicker({
					container: $(this).attr('data-container'),
					class:'w3-small',
					styles:'justify-content:center; padding:8px;'
				});
				
				$(this).on('click focus', function(event){ 
					event.stopPropagation(); 
					App.Large.closeFloatingInput();
					$($(this).attr('data-container')).show(); 
				}).on('change pick', function(event){ 
					$($(this).attr('data-value')).val($(this).val()); 
				}).on('hide', function(event){ 
					$($(this).attr('data-container')).hide(); 
				});
			});
		},
		inputLostFocus: function(){
			
		}
	}
</script>
@endSection