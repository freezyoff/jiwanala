@if ($data->isActive())
<a href="{{route('my.bauk.employee.activate',[$data->id,0])}}" 
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

@if(Auth::user()->hasPermission('bauk.patch.employee'))
<a href="{{route('my.bauk.employee.edit',['id'=>$data->id])}}" 
	style="text-decoration:none;"
	class="w3-large w3-text-green w3-hover-text-black padding-left-8" 
	title="Rubah data">
	<i class="fas fa-edit"></i>
</a>
@endif

@if(Auth::user()->hasPermission('bauk.delete.employee'))
<a href="#" onclick="$('.delete-modal-{{$data->id}}').show()" 
	class="w3-large w3-text-red w3-hover-text-black padding-left-8" 
	title="Hapus data"><i class="fas fa-trash"></i></a>
	<!-- begin: action delete modal -->
	<div class="delete-modal-{{$data->id}} w3-modal w3-display-container" onclick="$(this).hide()">
		<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:600px; text-align:left;">
			<header class="w3-container w3-theme">
				<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
					onclick="$('.delete-modal-{{$data->id}}').hide()" 
					style="font-size:20px !important">
					×
				</span>
				<h4 class="padding-top-8 padding-bottom-8">
					<i class="fas fa-trash"></i>
					<span style="padding-left:12px;">{{trans('my/bauk/employee/landing.hints.modal')}}</span>
				</h4>
			</header>
			<div class="w3-bar-block" style="width:100%">
				<div class="w3-container padding-top-bottom-16">
					<div style="display:flex">
						<div style="flex-shrink:1; min-width:80px;">NIP</div>
						<div>: {{$data->nip}}</div>
					</div>
					<div style="display:flex">
						<div style="flex-shrink:1; min-width:80px;">Nama</div>
						<div>: {{$data->name_front_titles.' '.$data->name_full.' '.$data->name_back_titles}}</div>
					</div>
				</div>
				<div class="w3-container padding-top-bottom-8" style="display: flex; justify-content:end;">
					<button class="w3-button w3-green w3-hover-green" 
						type="button" 
						onclick="$('.delete-modal-{{$data->id}}').hide()" >
						<i class="fas fa-times"></i>
						<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_cancel')}}</span>
					</button>
					<button class="w3-button w3-red w3-hover-red margin-left-8" 
						type="button" 
						onclick="document.location='{{route('my.bauk.employee.delete',['id'=>$data->id])}}'">
						<i class="fas fa-trash"></i>
						<span class="padding-left-8">{{trans('my/bauk/employee/landing.hints.btn_submit')}}</span>
					</button>
				</div>
			<div>
		</div>
	</div>
	<!-- end: action delete modal -->
@endif