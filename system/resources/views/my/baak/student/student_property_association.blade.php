<ul class="w3-ul w3-hoverable">
	@foreach(trans('my/baak/student/add.select.property_association') as $key=>$item)
	<li style="cursor:pointer;">
		<a class="w3-text-theme w3-mobile" 
			select-role="item" 
			select-value="{{$key}}">
			{{str_replace(":property",$type, $item)}}
		</a>
	</li>
	@endforeach
</ul>