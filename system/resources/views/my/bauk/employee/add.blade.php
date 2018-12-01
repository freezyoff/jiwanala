@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>'Manajemen Karyawan'])

@section('dashboard.main')
<div class="w3-row" style="padding-bottom:16px; ">
	<form id="form1" 
		method="post" 
		action="{{route('my.bauk.employee.add')}}">
		<div class="w3-card w3-round w3-col s12 m12 l8 ">
			<header class="w3-container w3-theme-l1 padding-top-bottom-8">
				<h4>Karyawan Baru</h4>
			</header>
			<div class="w3-container">
				<div class="padding-top-16 padding-bottom-8">
						@csrf
						<input name="NIP" type="text" value="{{old('NIP')}}" 
							placeholder="{{trans('my/bauk/employee/add.hints.NIP')}}" 
							class="w3-input
							@if(isset($errors) && $errors->has('NIP'))
								error
							@endif
							" />
						@if(isset($errors) && $errors->has('NIP'))
							<label class="w3-text-red">{{$errors->first('NIP')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
						<input name="KTP" type="text" value="{{old('KTP')}}" 
						placeholder="{{trans('my/bauk/employee/add.hints.KTP')}}" 
							class="w3-input
							@if(isset($errors) && $errors->has('KTP'))
								error
							@endif
							"/>
						@if(isset($errors) && $errors->has('KTP'))
							<label class="w3-text-red">{{$errors->first('KTP')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
						<input name="nama_lengkap" type="text" value="{{old('nama_lengkap')}}" 
							placeholder="{{trans('my/bauk/employee/add.hints.nama_lengkap')}}" 
							class="w3-input
							@if(isset($errors) && $errors->has('nama_lengkap'))
								error
							@endif
							"/>
						@if(isset($errors) && $errors->has('nama_lengkap'))
							<label class="w3-text-red">{{$errors->first('nama_lengkap')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
						<div class="input-group
							@if(isset($errors) && $errors->has('tlp1'))
									error
								@endif
							">
							<label>+62</label>
							<input name="tlp1" type="text" value="{{old('tlp1')}}" 
								placeholder="{{trans('my/bauk/employee/add.hints.tlp1')}}" class="input w3-input"/>
						</div>
						@if(isset($errors) && $errors->has('tlp1'))
							<label class="w3-text-red">{{$errors->first('tlp1')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
				</div>
				<div class="w3-hide-small padding-bottom-16" style="text-align:right">
					<button class="w3-button w3-red" type="button" onclick="document.location='{{route('my.bauk.employee')}}'">Batal</button>
					<button class="w3-button w3-blue margin-left-8" type="submit">Simpan</button>
				</div>
				<div class="w3-hide-large w3-hide-medium padding-top-8 padding-bottom-16" style="text-align:right">
					<button class="w3-button w3-red w3-mobile" type="button" onclick="document.location='{{route('my.bauk.employee')}}'">Batal</button>
					<button class="w3-button w3-blue w3-mobile margin-top-bottom-8" type="submit">Simpan</button>
				</div>
			</div>			
		</div>
	</form>
	<div class="w3-hide-small w3-hide-medium w3-col l4 padding-left-16">
		<div class="container padding-top-bottom-8">
			<h4>Note:</h4>
			<div class="legend">
				<h5>Nomor Induk Pegawai:</h5>
				<div style="display:flex; justify-content:space-between; align-content:center; font-size:.8em">
					<div style="flex-grow:1; text-align:center;">&#8826;Tahun Masuk&#8827;</div>
					<div style="flex-grow:1; text-align:center;">&#8826;Bulan Lahir&#8827;</div>
					<div style="flex-grow:1; text-align:center;">&#8826;Nomor Urut&#8827;</div>
				</div>
				<div style="display:flex; justify-content:space-between; align-content:center; font-size:.8em">
					<div style="flex-grow:1; text-align:center;">4 digit</div>
					<div style="flex-grow:1; text-align:center;">2 digit</div>
					<div style="flex-grow:1; text-align:center;">2 digit</div>
				</div>
			</div>
			<div class="legend">
				<h5>Nomor Kartu Tanda Penduduk:</h5>
				<p>Sesuai dengan nomor KTP. Panjang 2 sampai dengan 20 karakter. Pastikan belum pernah digunakan oleh karyawan lain.</p>
			</div>
			<div class="legend">
				<h5>Nama Lengkap:</h5>
				<p>Gunakan karakter alpabet. Isi nama tanpa gelar.</p>
			</div>
			<div class="legend">
				<h5>Nomor Telepon / Handphone:</h5>
				<p>Tanpa menggunakan angka depan nol.</p> 
				<p>Contoh: 0811xxxx &#x2192; 811xxxx</p>
			</div>
		</div>
	</div>
</div>
@endSection