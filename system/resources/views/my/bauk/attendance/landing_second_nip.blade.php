<label for="{{$krow}}{{$kline}}" 
	style="min-width:125px;">
	{{strtoupper(preg_replace('/[_]/',' ',$krow))}}
</label>
<input id="{{$krow}}{{$kline}}"
	class="w3-input input"
	type="text"
	name="{{$krow}}[{{$kline}}]"
	value="{{$vrow}}"/>