<div id="month-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium">
	<ul class="w3-ul w3-hoverable">
		@for($i=1;$i<13;$i++)
		<li style="cursor:pointer;">
			<a class="w3-text-theme w3-mobile" 
				select-role="item" 
				select-value="{{$i<10? '0'.$i : $i}}">
				{{ trans('calendar.months.long.'.($i-1)) }}
			</a>
		</li>
		@endfor
	</ul>
</div>