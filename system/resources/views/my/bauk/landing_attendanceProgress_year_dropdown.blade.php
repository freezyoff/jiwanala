<div id="attendanceProgress-year-dropdown" 
	class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium"
	style="z-index:100;">
	<ul class="w3-ul w3-hoverable">
		@for($i=now()->format('Y')-2;$i<now()->format('Y')+3;$i++)
		<li style="cursor:pointer;">
			<a class="w3-text-theme w3-mobile" 
				select-role="item" 
				select-value="{{$i}}">
				{{$i}}
			</a>
		</li>
		@endfor
	</ul>
</div>