<form class="w3-hide-medium w3-hide-large">
@foreach($imported as $row=>$value)

	{{-- begin: submit input --}}
	<input name="nip[{{$row}}]" type="hidden" />
	<input name="tanggal[{{$row}}]" type="hidden" />
	<input name="finger[{{$row}}][masuk]" type="hidden" />
	<input name="finger[{{$row}}][keluar][0]" type="hidden" />
	<input name="finger[{{$row}}][keluar][1]" type="hidden" />
	<input name="finger[{{$row}}][keluar][2]" type="hidden" />
	<input name="finger[{{$row}}][keluar][3]" type="hidden" />
	{{-- end: submit input --}}
	
	<div class="w3-mobile w3-container {{$row%2>0? 'w3-light-grey' : 'w3-white'}} padding-top-8 padding-bottom-16">
	
		{{-- begin: nip  --}}
		<div class="input-group">
			<label for="nip-{{$row}}-small" style="min-width:125px;">NIP</label>
			<input id="nip-{{$row}}-small"
				data-toggle="textlabel"
				data-value=""
				class="w3-input input"
				type="text"
				name="nip[{{$row}}][small]"
				value="{{$value['nip']}}" />
		</div>
		{{-- end: nip  --}}
		
		{{-- begin: tanggal  --}}
		<div class="input-group">
		
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
			
		</div>
		@include('my.bauk.attendance.landing_second_date_modal')
		{{-- end: tanggal  --}}
		
		{{-- begin: Finger  --}}
		@foreach(['finger_masuk','finger_keluar_1','finger_keluar_2','finger_keluar_3'] as $key)
		
		@endforeach
		{{-- end: Finger  --}}
	</div>
@endforeach
</form>