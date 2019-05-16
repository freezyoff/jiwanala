<ul class="w3-ul w3-hoverable">
	@foreach(trans($trans.'.select.register_types') as $key=>$item)
	<li style="cursor:pointer;">
		<a class="w3-text-theme w3-mobile" 
			select-role="item" 
			select-value="{{$key}}">
			{{$item}}
		</a>
	</li>
	@endforeach
</ul>