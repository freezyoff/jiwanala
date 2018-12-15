<label for="{{$krow}}[{{$kline}}]-large" 
	style="min-width:125px;"
	class="">
	{{ucwords(preg_replace('/[_]/',' ',$krow))}}
</label>

<input name="{{$krow}}[{{$kline}}]" type="hidden" />

<input id="{{$krow}}{{$kline}}-small"
	name="{{$krow}}[{{$kline}}][small]"
	data-toggle="timepicker"
	data-modal="#{{$krow}}{{$kline}}-modal"
	data-container="#{{$krow}}{{$kline}}-container"
	data-value="input[name='{{$krow}}[{{$kline}}]']"
	class="w3-input input w3-hide-large"
	type="text"
	value="{{$vrow}}"
	placeholder="Jam : Menit"
	readonly="readonly"/>
	
<input id="{{$krow}}{{$kline}}-large"
	name="{{$krow}}[{{$kline}}][large]"
	data-toggle="timepicker"
	data-modal="#{{$krow}}{{$kline}}-dropdown"
	data-container="#{{$krow}}{{$kline}}-dropdown-content"
	data-value="input[name='{{$krow}}[{{$kline}}]']"
	class="w3-input input w3-hide-small w3-hide-medium"
	type="text"
	value="{{$vrow}}"
	placeholder="Jam : Menit"
	readonly="readonly"/>
	
<div id="{{$krow}}{{$kline}}-dropdown" class="w3-dropdown-click w3-hide-small w3-hide-medium">
	<div id="{{$krow}}{{$kline}}-dropdown-content" class="w3-dropdown-content w3-bar-block w3-border"></div>
</div>
@include('my.bauk.attendance.landing_second_finger_modal')