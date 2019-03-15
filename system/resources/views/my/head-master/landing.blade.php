@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/landing.title')])

@section('dashboard.main')
<div class="w3-row">
	<div id="statistics" 
		class="w3-col s12 m5 l5 w3-light-grey padding-left-8 padding-left-none-small 
				margin-top-8 margin-top-none-large margin-top-none-medium">
		<div class="w3-card">
			<header class="w3-container padding-top-8 w3-blue">
				<h4>Kehadiran</h4>
					<div class="input-group">
						<input id="statistics-division"
							name="statistics[division]"
							value="{{ old('statistics.division', isset($statistics['division'])? $statistics['division'] : '') }}"
							type="text" 
							class="w3-input month" 
							role="select"
							select-dropdown="#statistics-division-dropdown"
							select-modal="#statistics-division-modal"
							select-modal-container="#statistics-division-modal-container" />
					</div>
					<div id="statistics-division-dropdown" 
						class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium"
						style="z-index:100;">
						<ul class="w3-ul w3-hoverable">
							@foreach(\Auth::guard('my')->user()->asEmployee->asDivisionManager as $division)
							<li style="cursor:pointer;">
								<a class="w3-text-theme w3-mobile" 
									select-role="item" 
									select-value="{{$division->code}}">
									{{$division->name}}
								</a>
							</li>
							@endforeach
						</ul>
					</div>
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
</div>
<div class="w3-row">
	
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	
});
</script>
@endSection