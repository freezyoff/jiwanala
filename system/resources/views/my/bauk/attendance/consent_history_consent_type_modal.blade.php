<div id="consent-type-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
				onclick="$('#consent-type-modal').hide()">
				×
			</h4>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-list-ul fa-fw"></i>
				<span style="padding-left:12px;">{{ucfirst(trans('my/bauk/attendance/pages.subtitles.consent'))}}</span>
			</h4>
		</header>
		<div id="consent-type-modal-container" class="datepicker-inline-container">
			<div class="w3-bar-block" style="width:100%">
				<ul class="w3-ul w3-hoverable">
					@foreach(trans('my/bauk/attendance/consent.types') as $key=>$val)
					<li style="cursor:pointer;">
						<a class="w3-text-theme w3-mobile" 
							select-role="item" 
							select-value="{{$key}}">
							{{$val}}
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>