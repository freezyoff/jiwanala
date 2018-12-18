<!-- begin: action delete modal -->
<div id="delete-modal-{{$holiday->id}}" class="w3-modal w3-display-container" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px; text-align:left;">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#delete-modal-{{$holiday->id}}').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-trash"></i>
				<span style="padding-left:12px;">Hapus Hari libur?</span>
			</h4>
		</header>
		<div class="w3-bar-block" style="width:100%">
			<div class="w3-container padding-top-bottom-16">
				@foreach(['name','start','end','repeat'] as $prop)
				<div style="display:flex">
					<div style="flex-shrink:1;">{{trans('my/bauk/holiday.validation.attributes.'.$prop)}}</div>
					<div>: {{$holiday->$prop}}</div>
				</div>
				@endforeach
			</div>
			<div class="w3-container padding-top-bottom-8" style="display: flex; justify-content:end;">
				<button class="w3-button w3-green w3-hover-green" 
					type="button" 
					onclick="$('#delete-modal-{{$holiday->id}}').hide()">
					<i class="far fa-times"></i>
					<span class="padding-left-8">{{trans('my/bauk/holiday.hints.back')}}</span>
				</button>
				<button class="w3-button w3-red w3-hover-red margin-left-8" 
					type="button" 
					onclick="document.location='{{route('my.bauk.holiday.delete',[$holiday->id])}}'">
					<i class="fas fa-trash"></i>
					<span class="padding-left-8">{{trans('my/bauk/holiday.hints.delete')}}</span>
				</button>
			</div>
		<div>
	</div>
</div>
<!-- end: action delete modal -->