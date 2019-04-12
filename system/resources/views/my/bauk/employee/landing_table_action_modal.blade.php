<!-- begin: action deactivate modal -->
<div id="deactivated-modal-{{$data->id}}" class="w3-modal w3-display-container datepicker-modal" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px; text-align:left;">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#deactivated-modal-{{$data->id}}').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-trash"></i>
				<span style="padding-left:12px;">{{trans('my/bauk/employee/landing.hints.modal_deactivate')}}</span>
			</h4>
		</header>
		<div class="w3-container" onclick="event.stopPropagation()" onfocus="event.stopPropagation()">
			<div class="w3-col s12 m6 l6 padding-right-8">
				<div class="input-group">
					<label><i class="fas fa-portrait"></i></label>
					<label class="input w3-input">{{$data->nip}}</label>
				</div>
				<div class="input-group">
					<label><i class="fas fa-font"></i></label>
					<label class="input w3-input">{{$data->name_front_titles.' '.$data->name_full.' '.$data->name_back_titles?: ''}}</label>
				</div>
				<div class="input-group">
					<label><i class="fas fa-calendar-day"></i></label>
					<input id="deactivated-input-{{$data->id}}"
						name="deactivated-input-{{$data->id}}" 
						value="{{now()->format('d-m-Y')}}"
						placeholder="{{trans('my/bauk/employee/landing.hints.deactivate_date')}}"
						data-id="{{$data->id}}"
						class="input w3-input datepicker" 
						type="text" />				
				</div>
				<div class="padding-top-16 padding-bottom-8 w3-hide-small" style="text-align:right">
					<button class="w3-button w3-hover-red w3-red margin-right-8" 
						onclick="$('#deactivated-modal-{{$data->id}}').hide()">
						<i class="fas fa-times"></i>
						<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_cancel')}}</span>
					</button>
					<button class="w3-button w3-hover-indigo w3-blue"
						onclick="App.deactivated.submit('{{$data->id}}')">
						<i class="fas fa-cloud-upload-alt"></i>
						<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_deactivate')}}</span>
					</button>
				</div>
			</div>
			<div class="w3-col s12 m6 l6 padding-bottom-16 padding-none-small">
				<div id="deactivated-modal-container-{{$data->id}}" class="datepicker-inline-container"></div>
			</div>
		</div>
		<div class="w3-container w3-hide-medium w3-hide-large padding-top-8 padding-bottom-8" style="text-align:right">
			<button class="w3-button w3-hover-red w3-red margin-right-8" 
					onclick="$('#deactivated-modal-{{$data->id}}').hide()">
				<i class="fas fa-times"></i>
				<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_cancel')}}</span>
			</button>
			<button class="w3-button w3-hover-indigo w3-blue"
				onclick="App.deactivated.submit('{{$data->id}}')">
				<i class="fas fa-cloud-upload-alt"></i>
				<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_deactivate')}}</span>
			</button>
		</div>
	</div>
</div>
<!-- end: action deactivate modal -->