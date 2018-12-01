@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>'Menejemen Karyawan'])

@section('dashboard.main')
<div style="padding-bottom:16px;">
	<a class="accordion" href="#" target="searchForm" style="cursor:pointer;">Opsi pencarian data</a>
	<div id="searchForm">@TODO</div>
</div>
<div class="w3-responsive">
	<table class="w3-table-all w3-hoverable">
		<thead>
			<tr>
				<td>NIP</td>
				<td>KTP</td>
				<td>Nama</td>
			</tr>
		</thead>
		<tbody>
			@if ($employees->count()>0)
				@foreach($employees as $data)
					<td>{{$data->NIP}}</td>
					<td>{{$data->KTP}}</td>
					<td>{{$data->nama_lengkap}}</td>
				@endforeach
			@else
				<td colspan="3">Belum ada data</td>
			@endif
		</tbody>
	</table>
</div> 
@endSection