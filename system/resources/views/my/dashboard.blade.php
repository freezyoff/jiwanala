@extends('layouts.baseLayout')

@section('html.head.styles')
	@parent
	<link rel="stylesheet" href="{{url('css/app.css')}}">
	<style>
		.brand>.brand-text>.subtitle {line-height:1.3; letter-spacing:.2px;}
		.brand{padding-top:8px; padding-bottom:8px;display:inline-block;}
		.w3-bar-item {float:none !important; display:inline-block !important;}
		.w3-main{margin-left:300px;}
		
		.brand>img {padding: 0;margin: 0;top:0;position:relative; vertical-align:middle;}
		.brand>.brand-text {position:relative; display:inline-block; vertical-align:middle;}
		.brand>.brand-text>.title {font-family:gotham-medium; font-weight:bold; line-height:1;}
		.brand>.brand-text>.subtitle {font-family:roboto,sanserif}
		
		@media only screen and (max-width: 600px) {
			.brand>img {width: 2em;}
			.brand>.brand-text {margin-left:.2em;}
			.brand>.brand-text>.title {font-size:1.1em}
			.brand>.brand-text>.subtitle {font-size:.6em;}
		}
		
		@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
		@media only screen and (min-width: 768px),			/* Medium devices (landscape tablets, 768px and up) */
		@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
		@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
			.brand>img {width: 2.5em;}
			.brand>.brand-text {margin-left:.5em;}
			.brand>.brand-text>.title {font-size:1.3em}
			.brand>.brand-text>.subtitle {font-size:.75em;}
		}
	</style>
@endSection

@section('html.body.content')
	<!-- begin: Top Bar -->
	<div id="jn-topbar" class="w3-bar w3-top w3-black w3-large w3-card " style="z-index:4">
	@section('dashboard.topbar')
		@include('my.dashboard_topbar')	
	@show
	</div>
	<!-- end: Top Bar -->
	
	<!-- begin: Sidebar/menu -->
	<nav id="jn-sidebar"
		class="w3-sidebar w3-collapse w3-white w3-animate-left" 
		style="z-index:3;width:300px;" >
	@section('dashboard.sidebar')
		@include('my.dashboard_sidebar')
	@show
	</nav>
	<!-- end: Sidebar/menu -->
	
	<!-- begin: Sidebar overlay -->
	@section('dashboard.sidebar.overlay')
	<!-- Overlay effect when opening sidebar on small screens -->
	<div class="w3-overlay w3-hide-large w3-animate-opacity" 
		style="cursor:pointer" 
		title="close side menu" 
		id="jn-sidebar-overlay"></div>
	<!-- end: Sidebar/menu -->
	@show

	<!-- begin: Main / Page Content -->
	@section('dashboard.main')
	<div class="w3-main" id="jn-main">
		@include('my.dashboard_main')
	
		<!-- begin: Footer  -->
		@section('dashboard.footer')
		<footer class="w3-container w3-padding-16 w3-light-grey">
			<h4>
				FOOTER
			</h4>
			<p>
				Powered by
				<a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a>
			</p>
		</footer>
		@show
		<!-- end: Footer  -->
		
	@show
	</div>
	<!-- end: Main / Page Content -->

	@section('dashboard.pagescipts')
	<script>
		var dashboard = {
			initSideBar: function(){
				$('#jn-main').css('margin-top',$("#jn-topbar").height()+'px');
				$('#jn-sidebar').css('top',$("#jn-topbar").height()+'px');
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
		}

		$(document).ready(function(){
			dashboard.initSideBar();
			$( window ).resize(function() { dashboard.initSideBar(); });
			$('#jn-sidebar-toggle').on('click', function(){ dashboard.toggleSideBar(); });
			$('#jn-sidebar-overlay').on('click', function(){ dashboard.closeSideBar(); });
		});
	</script>
	@show
@endSection