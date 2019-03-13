@extends('layouts.baseLayout')

@section('html.head.styles')
	@parent
	<link rel="stylesheet" href="{{url('font/stylesheet.css')}}">
	<link rel="stylesheet" href="{{url('css/app.css?'.csrf_token())}}">
	<style>
		body {background:#fefefe;}
		h2 {font-size:19px;}
		h3 {font-size:16px;}
		h4 {font-size:14px;}
		
		@media (max-width: 600px) {
			.w3-theme {background-color:#f1f1f1 !important; color:#333 !important;}
			
			#brandTag {
				display:flex; align-items:center; padding:8px 16px; background:#222222; color:#fefefe; 
				box-shadow:0 0 4px 1px #0003;
			}
			#brandTag img.image {width:2.8em;}
			#brandTag .title {font-family:'Proxima Nova'; font-size:1.4em; letter-spacing:.5px; font-weight:bold; line-height:1.2; }
			#brandTag .subtitle {line-height:1; font-size:.75em;}
		}
			
		@media only screen and (min-width: 600px), 			/* Small devices (portrait tablets and large phones, 600px and up) */
		@media only screen and (min-width: 768px){			/* Medium devices (landscape tablets, 768px and up) */
		
		}
		@media only screen and (min-width: 992px),			/* Large devices (laptops/desktops, 992px and up) */
		@media only screen and (min-width: 1200px) {		/* Extra large devices (large laptops and desktops, 1200px and up) */
			.w3-display-middle{min-width:400px;}
		
			img.brand {width: 6em; padding: 0;margin: 0;top:0;position:relative; vertical-align:top;}
			.brand-title {font-family:'Proxima Nova'; font-size:1.9em; letter-spacing:.5px; font-weight:bold; line-height:1.2; }
			.brand-subtitle {line-height:1; font-size:1em;}
			.w3-card.boxContainer{padding: 16px 32px 16px 32px;box-shadow: 0 2px 5px 0 rgba(200,200,200,0.26),0 2px 10px 0 rgba(200,200,200,0.22)}
			.w3-panel.error{padding: 16px 0 16px 0;}
		}
	</style>
@endSection

@section('body.attributes')
	class="w3-theme"
@endSection

@section('html.body.content')
<div id="brandTag">
	<img class="image" src="{{url('media/img/brand.png')}}" width="3em">
	<div class="padding-left-8" style="">
		<h1 class="title">JIWANALA</h1>
		<div class="subtitle">Learn . Explore . Lead</div>
	</div>
</div>

<div class="">
	<div class="w3-row">
		<div class="w3-container padding-top-bottom-16">
			<h2>PPDB 2019/2020<h2>
		</div>
	</div>
	<div class="w3-row padding-top-16 w3-center" style="">
		<footer class="w3-container w3-display-bottom padding-right-32 padding-left-32">
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
	</div>
</div>
	
@endSection