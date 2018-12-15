<div class="input-group">
	
	{{-- submit input --}}
	<input name="tanggal[{{$row}}]" type="hidden" />
	
	{{-- begin: small screen --}}
	<label for="tanggal-{{$row}}-small" style="min-width:125px;" class="w3-hide-large">Tanggal</label>
	<input id="tanggal-{{$row}}-small"
		name="tanggal[{{$row}}][small]"
		data-toggle="datepicker-modal"
		data-value="input[name='tanggal[{{$row}}]']"
		data-modal="#tanggal-{{$row}}-modal"
		data-container="#tanggal-{{$row}}-modal-container"
		class="w3-input input w3-hide-large"
		type="text"
		value="{{$value['tanggal']}}" />
	{{-- end: small screen --}}
	
	{{-- begin: large screen --}}
	<label for="tanggal-{{$row}}-large" style="min-width:125px;font-size:inherit" class="w3-hide-small w3-hide-medium">Tanggal</label>
	<input id="tanggal-{{$row}}-large"
		name="tanggal[{{$row}}][large]"
		data-toggle="datepicker"
		data-value="input[name='tanggal[{{$row}}]']"
		class="w3-input input w3-hide-small w3-hide-medium"
		type="text"
		value="{{$value['tanggal']}}" />
	{{-- begin: large screen --}}
	
</div>
@include('my.bauk.attendance.landing_second_date_modal')