@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/landing.page.title')])

@section('html.head.styles')
@parent
<style>
	/* SMALL */
	@media only screen and (max-width: 600px) {		
		#small {min-width:200px;}
		#small .btn-upload{
			display:table-cell; 
			border-radius:100%; 
			width:100px; 
			height:100px; 
			text-align:center; 
			vertical-align:middle;
			position:relative;
			left:50%;
			background-color:#008DFF;
			color:#FCFCFC;
		}
		
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
<div id="step-1" class="{{isset($step) && $step==2? 'w3-hide' : ''}}">
	<div id="small" class="w3-display-middle w3-hide-medium w3-hide-large">
		<label for="inpUpload" class="w3-xxlarge w3-card btn-upload">
			<i class="fas fa-cloud-upload-alt fa-fw"></i>
		</label>
		<i class="fa loader w3-hide"></i>
		<div class="w3-xlarge" style="margin:10px; text-align:center; font-weight:500;">Upload File</div>
	</div>
	<div id="medium" class="w3-container w3-hide-small w3-hide-large"></div>
	<div id="large" class="w3-container w3-hide-small w3-hide-medium"></div>
	<form id="fmUpload" action="{{route('my.bauk.attendance')}}" method="post" enctype="multipart/form-data">
		@csrf
		<input name="step" value="1" type="hidden" />
		<input id="inpUpload" name="upload" type="file" accept=".csv" class="w3-hide" />
	</form>
</div>
@if (isset($imported))
	<div id="step-2" class="w3-card w3-theme">
		<header class="w3-container">
			<h3>Review Data</h3>
		</header>
		@if (isset($errors))
		<div class="w3-mobile">
			@foreach($imported as $kline=>$vline)
			<div class="w3-container {{$kline%2>0? 'w3-light-grey' : 'w3-white'}} padding-top-8 padding-bottom-8" 
				style="display:flex;">
				<div style="min-width:50px; text-align:center;">{{$kline}}</div>
				<div style="flex-grow:2; display:flex; flex-direction:column;">
				@foreach($vline as $krow=>$vrow)
					<div>
						<div class="input-group">
							<label style="min-width:125px;">{{$krow}}</label>
							<input class="w3-input input" type="text" value="{{$vrow}}" />
						</div>
						@if ($errors->has($kline.'.'.$krow))
							<label class="w3-text-red">{{$errors->first($kline.'.'.$krow)}}</label>
						@else
							<label></label>
						@endif
					</div>
				@endforeach
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
@endif
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
		
	}
	
	App.UI.upload = {
		init: function(){
			$('#inpUpload').change(App.UI.upload.doUpload);
		},
		doUpload: function(){
			$('#fmUpload').submit();
		}
	}

	$(document).ready(function(){
		App.UI.upload.init();
		App.UI.small.init();
	});
</script>
@endSection