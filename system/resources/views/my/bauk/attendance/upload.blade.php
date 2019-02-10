@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.upload')])

@section('dashboard.main')
<div class="w3-card margin-bottom-16">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.upload_import')}}</h4>
	</header>
	<div class="w3-row padding-top-bottom-8">
		<div class="w3-col s12 m12 l6">
			<div class="w3-panel margin-left-8 margin-right-8">
				<span class="w3-large">{{trans('my/bauk/attendance/hints.download')}}<span>
				<a href="{{route('my.bauk.attendance.download',['csv'])}}" class="w3-xlarge w3-hover-text-indigo margin-left-8">
					<i class="fas fa-file-csv fa-fw"></i>
				</a>
				<a href="{{route('my.bauk.attendance.download',['excel'])}}" class="w3-xlarge w3-hover-text-purple margin-left-8">
					<i class="fas fa-file-excel fa-fw"></i>
				</a>				
			</div>
			@include('my.bauk.attendance.upload_form')
		</div>
		<div class="w3-col s12 m12 l6 w3-hide-small w3-hide-medium">
			@foreach(trans('my/bauk/attendance/hints.info') as $key=>$item)
			<h6 style="padding-top:{{$key>0? '.5':'.3' }}em; font-size:1.1em"><strong>{{$item['h6']}}</strong></h6>
			<p style="font-size:1em">{!! $item['p'] !!}</p>
			@endforeach
		</div>
	</div>
</div>
@if(\Session::has('fails'))
<div class="w3-card ">
	<header class="w3-container w3-red padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.upload_error')}}</h4>
	</header>
	<div class="w3-container padding-top-16 padding-bottom-16">
		<div class="w3-responsive">
			<table class="w3-table w3-table-all">
				<thead>
					<tr class="w3-theme-l1">
						<td>Baris</td>
						<td>NIP</td>
						<td>Tanggal</td>
						<td>Finger Masuk</td>
						<td>Finger Keluar</td>
						<td>Finger Keluar</td>
						<td>Finger Keluar</td>
					</tr>
				</thead>
				<tbody>
					@foreach(\Session::get('fails') as $key=>$row)
					<tr>
						<td class="w3-text-red">{{$key-1}}</td>
						@foreach(['nip','tanggal','finger_masuk','finger_keluar_1','finger_keluar_2','finger_keluar_3'] as $value)
							<td class="w3-text-red">{{ isset($row[$value]) && !($row[$value] instanceof Boolean)? $row[$value] : '' }}</td>
						@endforeach
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endif
@endSection

@section('html.body.scripts')
@parent
<script>
	$('[select-role="dropdown"]').select();
	$('#file').change(function(event){
		$(this).prev().html(event.target.files[0].name);
	});
</script>
@endSection