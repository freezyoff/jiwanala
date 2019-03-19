<div id="division-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium">
	<ul class="w3-ul w3-hoverable">
		@foreach($divisions as $dd)
		<li style="cursor:pointer;">
			<a class="w3-text-theme w3-mobile" 
				select-role="item" 
				select-value="{{$dd->code}}">
				({{$dd->code}}) {{$dd->name}}
			</a>
		</li>
		@endforeach
	</ul>
</div>
<div id="division-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#division-modal').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-calendar-alt"></i>
				<span style="padding-left:12px;">{{trans('my/bauk/holiday.hints.end')}}</span>
			</h4>
		</header>
		<div id="division-modal-container" class="datepicker-inline-container">
			<div class="w3-bar-block" style="width:100%">
				<ul class="w3-ul w3-hoverable">
					@foreach($divisions as $dd)
					<li style="cursor:pointer;">
						<a class="w3-text-theme w3-mobile" 
							select-role="item" 
							select-value="{{$dd->code}}">
							({{$dd->code}}) {{$dd->name}}
						</a>
					</li>
					@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>