{{-- begin: step second  --}}
@if (isset($imported))
	<div id="step-2" class="w3-card w3-theme w3-col s12 m12 l8">
		<header class="w3-container padding-top-8 padding-bottom-8">
			<h3>Review Data</h3>
		</header>
		@if (isset($errors))
		<div class="w3-mobile">
	
			@foreach($imported as $kline=>$vline)
			<div class="w3-container {{$kline%2>0? 'w3-light-grey' : 'w3-white'}} padding-top-8 padding-bottom-16">
				<div style="flex-grow:2; display:flex; flex-direction:column;">
				
				@foreach($vline as $krow=>$vrow)
					<div class="input-group
						@if ($errors->has($kline.'.'.$krow))
							error
						@endif
						">
						
						@if(preg_match('/tanggal/',$krow))
							@include('my.bauk.attendance.landing_second_datepicker')
						@elseif(preg_match('/finger/',$krow))
							@include('my.bauk.attendance.landing_second_finger')
						@else
							@include('my.bauk.attendance.landing_second_nip')
						@endif
							
					</div>
					@if ($errors->has($kline.'.'.$krow))
						<label class="w3-small w3-text-red">{{$errors->first($kline.'.'.$krow)}}</label>
					@else
						<label class="w3-small"></label>
					@endif
				@endforeach
				
				</div>
			</div>
			@endforeach
		</div>
		@endif
	</div>
@endif
{{-- end: step second  --}}