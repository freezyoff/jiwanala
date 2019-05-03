@if ($data->isActive())
	<a 	href="#"
		onclick="App.deactivated.show('{{$data->id}}')"
		style="text-decoration:none;"
		class="w3-large w3-text-black w3-hover-text-indigo" 
		title="Klik untuk menonaktifkan karyawan">
		<i class="far fa-lightbulb"></i>
	</a>
@else
<a href="{{route('my.bauk.employee.activate',[$data->id,1])}}" 
	style="text-decoration:none;"
	class="w3-large w3-text-indigo w3-hover-text-black" 
	title="Klik untuk mengaktifkan karyawan">
	<i class="fas fa-lightbulb"></i>
</a>
@endif

@if(Auth::user()->hasPermission('bauk.employee.patch'))
<a href="{{route('my.bauk.employee.edit',['id'=>$data->id])}}" 
	style="text-decoration:none;"
	class="w3-large w3-text-green w3-hover-text-black padding-left-8" 
	title="Rubah data">
	<i class="fas fa-edit"></i>
</a>
@endif

@if(Auth::user()->hasPermission('bauk.employee.delete'))
<a onclick="$('#delete-modal-{{$data->id}}').show()" 
	class="w3-large w3-text-red w3-hover-text-black padding-left-8" 
	title="Hapus data"><i class="fas fa-trash"></i>
</a>
@endif