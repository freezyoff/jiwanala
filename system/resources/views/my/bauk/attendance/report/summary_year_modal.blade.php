<div id="summary-year-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#summary-year-modal').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-calendar-alt"></i>
				<span style="padding-left:12px;">{{ucfirst(trans('my/bauk/attendance/pages.subtitles.year'))}}</span>
			</h4>
		</header>
		<div id="summary-year-modal-container" class="datepicker-inline-container">
			<div class="w3-bar-block" style="width:100%">
				<ul class="w3-ul w3-hoverable">
					@foreach(\App\Libraries\Core\WorkYear::all() as $year)
					<li style="cursor:pointer;">
						<a class="w3-text-theme w3-mobile" 
							select-role="item" 
							select-value="{{$year->id}}">
							{{$year->name}}
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>