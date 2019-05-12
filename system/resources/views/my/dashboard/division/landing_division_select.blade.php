@foreach($divisions as $dd)
<li style="cursor:pointer;">
	<a class="w3-text-theme w3-mobile" 
		select-role="item" 
		select-value="{{$dd->id}}">
		({{$dd->id}}) {{$dd->name}}
	</a>
</li>
@endforeach