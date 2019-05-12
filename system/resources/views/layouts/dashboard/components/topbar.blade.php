<button class="w3-bar-item w3-button w3-hover-none {{$item->class}}"
	@if ($item->href)
	onclick="document.location='{{$item->href}}'" 
	@endif
	>
	<i class="{{$item->display->icon}}"></i>
	<span>{{ucfirst($item->display->name)}}</span>
</button>