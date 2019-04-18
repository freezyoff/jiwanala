<div id="viewer-modal-{{$date}}" class="w3-modal w3-display-container" onclick="event.stopPropagation(); $(this).hide();">
	<div id="viewer-modal-{{$date}}-file" 
		class="w3-modal-content w3-animate-top w3-card-4">
		@foreach($data['consent']->attachments()->get() as $att)
		<img alt="consent" 
			style="width:100%"
			src="data:{{$att->mime}};base64, {{base64_encode($att->attachment)}}" />
		@endforeach
	</div>
</div>