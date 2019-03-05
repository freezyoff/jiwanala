@extends('layouts.baseLayout')

@section('html.head.styles')
	@parent
	<link rel="stylesheet" href="{{url('font/stylesheet.css')}}">
	<link rel="stylesheet" href="{{url('css/app.min.css?'.csrf_token())}}">
	<style>
	{{asd}}
		.brand>img {position:relative;}
		.brand>.brand-text {position:relative;}
		.brand>.brand-text>.title {font-family:'Proxima Nova'; font-weight:bold;}
		.brand>.brand-text>.subtitle {line-height:.5;}
			
		@media only screen and (max-width: 600px) {
			.smallContainer{min-width:150px;}
			.smallContainer .errorContainer{padding-top:12px; padding-bottom:12px; border-top:1px solid #999999;}
			.smallContainer .errorContainer:first-child {border-top:transparent; padding-bottom:24px;}
			
			.brand>img {width: 4.5em;}
			.brand>.brand-text>.title {font-size:1.2em;}
			.brand>.brand-text>.subtitle {font-size:.75em; color:#f5f5f5;}
			
			.errorCode>h1{line-height:1;}
			.errorCode>h3{line-height:1.2; color:#f5f5f5;}
			
			.copy{ margin-top:32px; font-size:.8em; color:#84C9FF !important;}
		}
		
		@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
		@media only screen and (min-width: 768px),			/* Medium devices (landscape tablets, 768px and up) */
		@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
		@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
			.mediumLargeContainer{width:400px;}
			.mediumLargeContainer .errorContainer:first-child {padding-bottom:12px;}
			
			.brand {display:inline-block; vertical-align:middle;}
			.brand>img {width: 6em;}
			.brand>.brand-text>.title {font-size:1.5em;}
			.brand>.brand-text>.subtitle {font-size:.85em; color:#f5f5f5;}
			
			.errorCode>h1{line-height:1;}
			.errorCode>h3{line-height:1.2; color:#f5f5f5;}
			.copy{ margin-top:24px; font-size:.8em; color:#84C9FF !important;}
			
			.w3-col {padding-left:12px; padding-right:12px; vertical-align:middle; min-height:150px;}
		}
	</style>
@endSection

@section('html.body.attributes')
	class="w3-theme"
@endSection

@section('html.body.content')
	<div class="w3-card w3-display-middle w3-hide-medium w3-hide-large smallContainer">
		<div class="w3-center brand errorContainer">
			<img src="{{url('media/img/brand.png')}}">					
			<div class="brand-text">
				<div class="title">JIWANALA</div>
				<div class="subtitle">Learn . Explore . Lead</div>
			</div>
		</div>
		<div class="w3-center errorCode errorContainer">
			<h1>404</h1>
			<h3>Error</h3>
		</div>
		<div class="w3-center errorCode errorContainer">
			<p>Halaman Tidak ditemukan</p>
		</div>
		<div class="w3-center copy">
			<div>&copy; JIWANALA {{ date("Y") }}</div>
		</div>
	</div>
	<div class="brand w3-hide-small w3-display-middle mediumLargeContainer">
		<div class="w3-row">
			<div class="w3-col s6" style="border-right:1px solid #999999;padding-right:0;">
				<div class="rightBorder w3-center">
					<div class="brand">
						<img src="{{url('media/img/brand.png')}}">
						<div class="brand-text">
							<div class="title">JIWANALA</div>
							<div class="subtitle">Learn . Explore . Lead</div>
						</div>
					</div>
				</div>
			</div>
			<div class="w3-col s6" style="padding-right:0;">
				<div style="padding-top:5px;">
					<div class="w3-center errorCode errorContainer">
						<h1 style="font-size:3.5em">404</h1>
						<h3 style="font-size:2.5em">Error</h3>
					</div>
					<div class="w3-center errorCode errorContainer">
						<p>Halaman Tidak ditemukan</p>
					</div>
				</div>
			</div>
		</div>
		<div class="w3-row">
			<div class="w3-center copy">
				<div>&copy; JIWANALA {{ date("Y") }}</div>
			</div>
		</div>
	</div>
@endSection