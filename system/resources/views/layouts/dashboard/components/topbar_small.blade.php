<li class="w3-hover-light-grey" style="cursor:pointer;">
	<a class="w3-text-theme w3-mobile {{$item->display->class}}"
		style="text-decoration:none;"
		href="{{$item->href}}">
		<i class="{{$item->display->icon}}"></i>
		<span style="padding-left:12px">{{ucfirst($item->display->name)}}</span>
	</a>
</li>