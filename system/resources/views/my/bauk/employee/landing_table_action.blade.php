@if(Auth::user()->hasPermission('bauk.patch.employee'))
<a href="{{route('my.bauk.employee.edit',['id'=>$data->id])}}" 
	class="w3-large w3-hover-text-green" 
	title="Rubah data"><i class="fas fa-edit"></i></a>
@endif
@if(Auth::user()->hasPermission('bauk.delete.employee'))
<a href="{{route('my.bauk.employee.edit',['id'=>$data->id])}}" 
	class="w3-large w3-hover-text-red padding-left-8" 
	title="Hapus data"><i class="fas fa-trash"></i></a>
@endif