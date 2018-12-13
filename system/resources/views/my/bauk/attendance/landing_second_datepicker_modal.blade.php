<div id="{{$krow}}{{$kline}}-modal" 
	class="w3-modal w3-display-container w3-hide-large datepicker-modal" 
	onclick="$(this).hide()">
	
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#{{$krow}}{{$kline}}-modal').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-clock"></i>
				<span style="padding-left:12px;">{{trans('my/bauk/attendance/landing.hints.finger_time')}}</span>
			</h4>
		</header>
		<div id="{{$krow}}{{$kline}}-container" class="datepicker-inline-container"></div>
	</div>
	
</div>