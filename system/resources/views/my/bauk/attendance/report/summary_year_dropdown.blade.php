<div id="summary-year-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium">
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