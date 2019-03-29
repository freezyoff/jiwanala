<!-- begin: action deactivate modal -->
<div id="deactivated-modal-{{$data->id}}" class="w3-modal w3-display-container" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px; text-align:left;">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#deactivated-modal-{{$data->id}}').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-trash"></i>
				<span style="padding-left:12px;">{{trans('my/bauk/employee/landing.hints.modal')}}</span>
			</h4>
		</header>
		<input name="date[]" class="input w3-input datepicker w3-hide" type="text" readonly="readonly" />
		<div id="deactivated-modal-container-{{$data->id}}" class="datepicker-inline-container"></div>
	</div>
</div>
<script>
//{ format: 'dd-mm-yyyy', offset: 5, container: '#datepicker-inline-container', inline: true, language: 'id-ID'}
</script>
<!-- end: action deactivate modal -->