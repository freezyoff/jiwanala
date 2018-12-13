<label for="{{$krow}}[{{$kline}}]-small" 
	style="min-width:125px;"
	class="w3-hide-large">
	{{ucwords(preg_replace('/[_]/',' ',$krow))}}
</label>

<label for="{{$krow}}[{{$kline}}]-large" 
	style="min-width:125px;"
	class="w3-hide-small w3-hide-medium">
	{{ucwords(preg_replace('/[_]/',' ',$krow))}}
</label>

<input name="{{$krow}}[{{$kline}}]" type="hidden" />

<input id="{{$krow}}{{$kline}}-small"
	name="{{$krow}}[{{$kline}}][small]"
	data-toggle="datepicker-inline"
	data-value="{{$krow}}[{{$kline}}]"
	data-modal="{{$krow}}{{$kline}}-modal"
	data-container="{{$krow}}{{$kline}}-container"
	class="w3-input input w3-hide-large"
	type="text"
	value="{{$vrow}}"/>
	
<input id="{{$krow}}{{$kline}}-large"
	name="{{$krow}}[{{$kline}}][large]"
	data-toggle="datepicker"
	data-value="{{$krow}}[{{$kline}}]"
	class="w3-input input w3-hide-small w3-hide-medium"
	type="text"
	value="{{$vrow}}"/>

@include('my.bauk.attendance.landing_second_datepicker_modal')