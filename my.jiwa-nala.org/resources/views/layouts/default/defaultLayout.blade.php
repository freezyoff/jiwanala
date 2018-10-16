@extends('layouts.default.htmlBase')

@section('html.head.title')
	<title>{{ config('app.name') }}</title>
@endSection

@section('html.head.metas')
	<meta name="description" content="Latest updates and statistic charts" />         
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" />
@endSection

@section('html.head.scripts')
	<!-- begin::Web font -->
	<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
	<script>WebFont.load({            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},            active: function() {                sessionStorage.fonts = true;            }          });</script>
	<script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-37564768-1', 'auto');  ga('send', 'pageview');</script><script>  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');  ga('create', 'UA-37564768-1', 'auto');  ga('send', 'pageview');</script>
	<!--end::Web font -->                
@endSection

@section('html.head.styles')
	<!-- begin::Page Vendors Styles -->
	<link href="{{ asset('vendors/metronic/vendors/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
	<!-- end::Page Vendors Styles -->        		
	
	<!-- begin::Base Styles -->				
	<link href="{{ asset('vendors/metronic/vendors/base/vendors.bundle.css') }}" rel="stylesheet" type="text/css" />				
	<link href="{{ asset('vendors/metronic/demo/demo11/base/style.bundle.css') }}" rel="stylesheet" type="text/css" />		        
	<!-- end::Base Styles -->        
	
	<!-- @TODO: JIWANALA icon -->
	<link rel="shortcut icon" href="{{ asset('vendors/metronic/demo/demo11/media/img/logo/favicon.ico') }}" />     
	<!-- end TODO: -->
@endSection

@section('html.body.scripts')
	<!-- begin:: Vendor Scripts -->
	<!--[section: html.body.scripts.vendor]/-->
	@section('html.body.scripts.vendor')
		<!-- begin:: Vendor Base Scripts -->
		<script src="{{ asset('vendors/metronic/vendors/base/vendors.bundle.js') }}" type="text/javascript"></script>
		<script src="{{ asset('vendors/metronic/demo/demo11/base/scripts.bundle.js') }}" type="text/javascript"></script>
		<!-- end:: Vendor Base Scripts -->                    
	@show
	<!--[end section: html.body.scripts.vendor]/-->
	<!-- end:: Vendor Scripts -->
	
	<!-- begin::Page Snippets -->
	<!--[section: html.body.scripts.page]/-->
	@section('html.body.scripts.page')
	@show
	<!--[end section: html.body.scripts.page]/-->
	<!-- end::Page Snippets -->
@endSection

@section('html.body.page')
	@include('layouts.default.bodyBase')
@endSection