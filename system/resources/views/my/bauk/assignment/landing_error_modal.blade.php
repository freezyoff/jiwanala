<div id="error-modal" class="w3-modal w3-display-container" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-red">
			<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
				onclick="$('#error-modal').hide()">
				×
			</h4>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-times"></i>
				<span style="padding-left:12px;">{{trans('my/bauk/assignment.hints.error-modal')}}</span>
			</h4>
		</header>
		<div id="error-modal-container" class="datepicker-inline-container">
			<p class="w3-container padding-top-bottom-16" style="font-size:1em;"></p>
		</div>
	</div>
</div>