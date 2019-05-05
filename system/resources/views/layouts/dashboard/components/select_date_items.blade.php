@if(isset($month) && $month)
	@for($i=1; $i<13; $i++)
	<li style="cursor:pointer;">
		<a class="w3-text-theme w3-mobile" 
			select-role="item" 
			select-value="{{$i<10? '0'.$i : $i}}">
			{{ trans('calendar.months.long.'.($i-1)) }}
		</a>
	</li>
	@endfor
@endif

@if(isset($year) && $year)
	@for($i=now()->format('Y')-2;$i<=now()->format('Y')+1;$i++)
	<li style="cursor:pointer;">
		<a class="w3-text-theme w3-mobile" 
			select-role="item" 
			select-value="{{$i}}">
			{{$i}}
		</a>
	</li>
	@endfor
@endif