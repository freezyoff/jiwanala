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
				<span style="padding-left:12px;">{!! trans('my/bauk/holiday.hints.deleteModal') !!}</span>
			</h4>
		</header>
		<div class="w3-bar-block" style="width:100%">
			<div class="w3-responsive padding-bottom-16">
				<table class="w3-table w3-table-all">
					<tbody>
						@foreach(['name','start','end','repeat'] as $prop)
						<tr>
							<td width="200px">{{trans('my/bauk/holiday.validation.attributes.'.$prop)}}</td>
							@if ($prop == 'repeat')
								<td>: {{ ucwords(trans('my/bauk/holiday.hints.repeat_choice.'.$holiday->$prop)) }}</td>
							@else
								<td>: {{$holiday->$prop}}</td>
							@endif
						<tr>
						@endforeach
					</tbody>
				</table>	
			</div>
			<div class="w3-container padding-top-bottom-8" style="display: flex; justify-content:end;">
				<button class="w3-button w3-green w3-hover-green" 
					type="button" 
					onclick="$('#delete-modal-{{$holiday->id}}').hide()">
					<i class="fas fa-times"></i>
					<span class="padding-left-8">{{trans('my/bauk/holiday.hints.back')}}</span>
				</button>
				<form action="{{route('my.bauk.holiday.delete')}}" method="POST">
					@csrf
					<input name="id" value="{{ $holiday->id }}" type="hidden" />
					<button class="w3-button w3-red w3-hover-red margin-left-8" type="submit">
						<i class="fas fa-trash"></i>
						<span class="padding-left-8">{{trans('my/bauk/holiday.hints.delete')}}</span>
					</button>				
				</form>
			</div>
		<div>
	</div>
</div>
<!-- end: action delete modal -->