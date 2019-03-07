@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/landing.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	@include('my.bauk.landing_attendanceProgress')
	<div id="statistics" 
		class="w3-col s12 m5 l5 w3-light-grey padding-left-8 padding-left-none-small 
				margin-top-8 margin-top-none-large margin-top-none-medium">
	<div class="w3-card">
		<header class="w3-container padding-top-8 w3-blue">
			<h4>Statistik Karyawan Fulltime</h4>
		</header>
		<table class="w3-table w3-bordered">
			<thead>
				<tr class="w3-blue">
					<th>Keterangan / Status</th>
					<td></td>
					<th>Jumlah (org)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aktif</td>
					<td>:</td>
					<td id="employee-active" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime</td>
					<td>:</td>
					<td id="employee-fulltime" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime Kontrak thn ke 2</td>
					<td>:</td>
					<td id="employee-fulltime-contract-2" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime Kontrak thn ke 1</td>
					<td>:</td>
					<td id="employee-fulltime-contract-1" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="w3-row">
	@include('my.bauk.landing_holidays')
	{{-- @include('my.bauk.landing_fingerConsent')--}}
</div>
@endSection

@section('html.body.scripts')
@parent
<script>

var employeesCount = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.employeesCount')}}',
		data: { 
			'_token': '{{csrf_token()}}',
			'year': $('#attendanceProgress-year').val(),
			'month': $('#attendanceProgress-month').val(),
		},
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#employee-active').html(response.count+' org');
			$('#employee-fulltime').html(response.fulltime+' org');
			$('#employee-fulltime-contract-1').html(response.contract1+' org');
			$('#employee-fulltime-contract-2').html(response.contract2+' org');
		}
	});
};

$(document).ready(function(){
	employeesCount();
});
</script>
@endSection