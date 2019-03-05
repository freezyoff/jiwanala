<?php 
	//default options
	$sidebar = isset($sidebar)? $sidebar : false;
?>

@extends('layouts.baseLayout')

@section('html.head.styles')
	@parent
	<link rel="stylesheet" href="{{url('font/stylesheet.css')}}">
	<link rel="stylesheet" href="{{url('css/app.css')}}">
	<style>
		.brand{min-width:165px;padding-top:8px; padding-bottom:8px;text-decoration:none;}
		.brand>.brand-text>.subtitle {line-height:1.3; letter-spacing:.2px;}
		.brand>img {padding: 0;margin: 0;top:0;position:relative; vertical-align:middle;}
		.brand>.brand-text {position:relative; display:inline-block; vertical-align:middle;}
		.brand>.brand-text>.title {font-family:gotham; font-weight:bold; line-height:1;}
		.brand>.brand-text>.subtitle {font-family:roboto}
		
		#jn-sidebar{font-size:1.2em;}
		#jn-sidebar>.w3-bar-block>a {padding:0 !important;display:flex !important;align-items:center;text-decoration:none;}
		#jn-sidebar>.w3-bar-block>a>div.icon{padding:8px 16px 8px 16px;}
		#jn-sidebar>.w3-bar-block>a>.span{flex-grow:1}
		#jn-sidebar>.w3-bar-block>a.dashboard{background-color:#2DA157;}
		#jn-sidebar>.w3-bar-block>a.dashboard:hover{background-color:#2DA157 !important;}
		
		#jn-sidebar>.w3-bar-block>div.accordion-item>a{background-color:rgb(62, 62, 62);}
		
		#jn-sidebar>.w3-bar-block>a.w3-bar-item:hover,
		#jn-sidebar>.w3-bar-block>a.w3-bar-item.accordion:hover:after,
		#jn-sidebar>.w3-bar-block>div.accordion-item>a:hover {color: #93C7F0;}
		
		#jn-sidebar>.w3-bar-block>div.accordion-item>a.selected,
		#jn-sidebar>.w3-bar-block>a.w3-bar-item.selected{color: #93C7F0;background-color:rgba(200,200,200,.15) !important;}
		#jn-sidebar>.w3-bar-block>div.accordion-item>a.selected:after,
		#jn-sidebar>.w3-bar-block>a.w3-bar-item.selected:after{width: 0;height: 0;border-top: 10px solid transparent;border-right: 10px solid rgb(241, 241, 241);border-bottom: 10px solid transparent;right:0;position:absolute;content:'';}
		
		/*#jn-sidebar>.w3-bar-block>a.w3-bar-item.accordion:after {width: 0;height: 0;border-left: 8px solid transparent;border-right: 8px solid transparent;border-bottom: 8px solid rgb(241, 241, 241);border-top: none;position:absolute;right:16px;content:'';}*/
		#jn-sidebar>.w3-bar-block>a.w3-bar-item.accordion.collapse:after {border-top: 8px solid rgb(241, 241, 241);border-bottom: none;}
		
		#jn-sidebar>.w3-bar-block>div.accordion-item>a>div.icon{padding:4px 16px 4px 16px; visibility:hidden;}
		#jn-sidebar>.w3-bar-block>div.accordion-item>a>span{font-size:.9em}
		
		#jn-topbar.w3-card{box-shadow:0 2px 5px 0 rgba(0,0,0,.3),0 2px 10px 0 rgba(0,0,0,0.26)}
		.w3-bar-item {float:none !important; display:inline-block !important;}
		.top-nav{display:flex;flex-grow:2;flex-direction:row;align-items:stretch;justify-content:right;}
		#jn-topbar .top-nav>button:hover{
			background-color:rgba(255, 255, 255, 0.2) !important;
			color:rgb(241,241,241) !important;
		}
		
		@if(!$sidebar)
			.w3-main{margin-left:0 !important;}
			#jn-sidebar{width:0; !important}
		@else
			.w3-main{margin-left:300px;}
		@endif
		
		@media only screen and (max-width: 600px) {
			.brand{}
			.brand>img {width: 2em;}
			.brand>.brand-text {margin-left:.5em;}
			.brand>.brand-text>.title {font-size:1.1em}
			.brand>.brand-text>.subtitle {font-size:.6em;}	
			#jn-topbar>.w3-bar>.brand:first-child{padding-left:16px;}
		}
		
		@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
		@media only screen and (min-width: 768px){			/* Medium devices (landscape tablets, 768px and up) */
			.brand>img {width: 2.5em;}
			.brand>.brand-text {margin-left:.5em;}
			.brand>.brand-text>.title {font-size:1.3em;}
			.brand>.brand-text>.subtitle {font-size:.75em;}
			.top-nav>button>span{display:none;}
		}
		
		@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
		@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
			.brand>img {width: 2.5em;}
			.brand>.brand-text {margin-left:.5em;}
			.brand>.brand-text>.title {font-size:1.3em}
			.brand>.brand-text>.subtitle {font-size:.75em;}
			.top-nav>button>span{padding-left:4px; display:inline-block;}
		}
	</style>
@endSection

@section('html.body.attributes')
	class="w3-light-grey"
@endSection
@section('html.body.content')
	<!-- begin: Top Bar -->
	<div id="jn-topbar" class="w3-bar w3-top w3-theme w3-large w3-card " style="z-index:4">
	@section('dashboard.topbar')
		@include('layouts.dashboard.dashboard_topbar')	
	@show
	</div>
	<!-- end: Top Bar -->
	
	<!-- begin: Sidebar/menu -->
	@if($sidebar)
		@section('dashboard.sidebar')
		<div id="jn-sidebar"
			class="w3-sidebar w3-collapse w3-theme-l1 w3-animate-left" 
			style="z-index:3;width:300px;" >
			
			@section('dashboard.sidebar.items')
				@include('layouts.dashboard.dashboard_sidebar',['sidebar'=>$sidebar])
			@show
			
		</div>
		@show
	@endif
	
	<!-- end: Sidebar/menu -->
	
	<!-- begin: Sidebar overlay -->
	@section('dashboard.sidebar.overlay')
	<!-- Overlay effect when opening sidebar on small screens -->
	<div id="jn-sidebar-overlay" 
		class="w3-overlay w3-hide-large w3-animate-opacity" 
		style="cursor:pointer" 
		title="close side menu"></div>
	@show
	<!-- end: Sidebar overlay -->
	
	<!-- begin: Main / Page  -->
	<div class="w3-main" id="jn-main">
		<!-- begin: Main / Page Header -->
		@section('dashboard.header')
		<header class="w3-container" style="padding-top:8px; padding-bottom:8px;">
			<h3 style="font-weight:bold;">{!!isset($title)? $title : 'Page Title'!!}</h3>
		</header>
		@show
		<!-- end: Main / Page Header -->
		<!-- begin: Main / Page content -->
		<content class="w3-padding" style="display:block">
		@section('dashboard.main')
			@include('layouts.dashboard.dashboard_main')
		@show
		</content>
		<!-- end: Main / Page content -->
	
		<!-- begin: Footer  -->
		@section('dashboard.footer')
		<footer class="w3-container w3-padding-16" style="text-align:right;color:#333333">
			<div>&copy; <a href="{{url('')}}" style="font-weight:600;text-decoration:none;">JIWANALA</a> {{date('Y')}}</div>
			<div style="font-size:.85em">
				<span>Managed by </span>
				<a href="mailto:akhmad.musa.hadi@gmail.com" 
					target="_blank" 
					style="text-decoration:none;font-weight:bold">
					<span style="color:#ff5100cc;">Freezy</span><span style="color:#59B5FF;">Bits</span>
				</a>
			</div>
		</footer>
		@show
		<!-- end: Footer  -->
		
	</div>
	<!-- end: Main / Page Content -->
@endSection

@section('html.body.scripts')
<script>
	var dashboard = {
		initSideBar: function(){
			var height = $("#jn-topbar").height();
			$('#jn-main').css('margin-top',height+'px');
			$('#jn-main>content').css('min-height',$(document).height()-$('#jn-main>header').outerHeight()-$('#jn-main>footer').outerHeight()-height);
			$('#jn-sidebar').css('top',height+'px');
		},
		toggleSideBar: function(){
			if ($('#jn-sidebar').css('display') == 'none'){ this.openSideBar(); }
			else{ this.closeSideBar(); }
		},
		openSideBar: function(){
			$('#jn-sidebar').css('display', 'block');
			$('#jn-sidebar-overlay').css('display', 'block');
		},
		closeSideBar: function(){
			$('#jn-sidebar').css('display', 'none');
			$('#jn-sidebar-overlay').css('display', 'none');
		}
	};

	$(document).ready(function(){
		setInterval(function(){$('#serverTime').text( moment().tz('Asia/Jakarta').format("DD-MM-YYYY HH:mm:ss") );}, 1000);
		$( window ).resize(dashboard.initSideBar);
		$('.jn-sidebar-toggle').on('click', function(){ dashboard.toggleSideBar(); });
		$('#jn-sidebar-overlay').on('click', function(){ dashboard.closeSideBar(); });
		fontSpy('gotham', {
			success: function(){ dashboard.initSideBar(); }, 
			failure: function(){ dashboard.initSideBar(); }
		});
	});
</script>
@endSection