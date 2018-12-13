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
	@include('my.bauk.attendance.landing_first')
	@include('my.bauk.attendance.landing_second')
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('js/datepicker.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/datepicker.css')}}">
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
					$('#'+modal).hide();
					App.UI.datepicker.click.float(e);
				}
			},
		},
		showModal: function(e){
			$('#'+$(this).attr('data-modal')).show();
		},
		valueChange: function(e){
			var taget = $(e.target).attr('data-value');
			$('input[name="'+taget+'"]').val($(e.target).val());
		},
		init: function(){
			$('[data-toggle="datepicker-inline"]').each(function(){
				var opt = $.extend(App.UI.datepicker.format.inline, {container: '#'+$(this).attr('data-container')});
				$(this).datepicker(opt)
					.on('focus focusin', App.UI.datepicker.showModal)
					.on('pick.datepicker', App.UI.datepicker.click.inline)
					.on('value-change change keyup', App.UI.datepicker.valueChange);
			});	
		}
	};

	$(document).ready(function(){
		App.UI.upload.init();
		App.UI.small.init();
		App.UI.datepicker.init();
	});
</script>
@endSection