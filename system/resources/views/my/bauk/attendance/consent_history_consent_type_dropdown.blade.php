<div id="consent-type-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium">
	<ul class="w3-ul w3-hoverable">
		@foreach( trans('my/bauk/attendance/consent.types') as $key=>$val)
		<li style="cursor:pointer;">
			<a class="w3-text-theme w3-mobile" select-role="item" select-value="{{$key}}">{{$val}}</a>
		</li>
		@endforeach
	</ul>
</div>