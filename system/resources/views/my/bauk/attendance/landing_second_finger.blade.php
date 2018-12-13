<label for="{{$krow}}[{{$kline}}]-large" 
	style="min-width:125px;"
	class="">
	{{ucwords(preg_replace('/[_]/',' ',$krow))}}
</label>

<input id="{{$krow}}{{$kline}}"
	name="{{$krow}}[{{$kline}}]"
	data-toggle="timepicker-hour"
	data-modal="{{$krow}}{{$kline}}-modal"
	data-container="{{$krow}}{{$kline}}-container"
	class="w3-input input"
	type="text"
	value="{{$vrow}}"
	placeholder="Jam : Menit"/>

@include('my.bauk.attendance.landing_second_finger_modal')