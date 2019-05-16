@foreach(trans('gender.str_keys') as $key=>$item)
<li style="cursor:pointer;">
	<a class="w3-text-theme w3-mobile" 
		select-role="item" 
		select-value="{{$key}}">
		{{ $item }}
	</a>
</li>
@endforeach