@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>'Menejemen Karyawan'])

@section('html.head.styles')
@parent
<style>
.w3-hoverable tbody tr:hover, .w3-ul.w3-hoverable li:hover {
	background-color: #2196F31A;
	cursor:pointer;
}
</style>
@endSection

@section('dashboard.main')
<div style="padding-bottom:16px;">
	<div></div>
	<a class="accordion" href="#" target="searchForm" style="cursor:pointer;">Opsi pencarian data</a>
	<div id="searchForm">@TODO</div>
</div>
<div class="w3-responsive">
	<table class="w3-table-all w3-hoverable">
		<thead>
			<tr>
				<td class="w3-theme-l1 w3-hide-large"></td>
				<td class="w3-theme-l1">NIP</td>
				<td class="w3-theme-l1">Nama</td>
				<td class="w3-theme-l1 w3-center"></td>
				<td class="w3-theme-l1">Telepon</td>
				<td class="w3-theme-l1 w3-hide-small w3-hide-medium"></td>
			</tr>
		</thead>
		<tbody>
			@if ($employees->count()>0)
				@foreach($employees as $data)
				<?php 
					$person = $data->asPerson()->first();
				?>
				<tr style="vertical-align:middle">
					<td class="w3-hide-large padding-left-8">@include('my.bauk.employee.landing_table_action')</td>
					<td>{{$data->nip?: ''}}</td>
					<td>{{$person->name_front_titles.' '.$person->name_full.' '.$person->name_back_titles?: ''}}</td>
					<td class="w3-center">
						<span class="w3-tag"
							title="{{$data->workTime()}}">
						@if($data->isWorkTime('f'))
							<i class="fas fa-clock"></i>
						@elseif($data->isWorkTime('p'))
							<i class="fas fa-stopwatch"></i>
						@endif
						</span>
						<span class="w3-tag"
							title="{{$data->isActive()? 'Aktif' : 'Non Aktif'}}">
							@if($data->isActive())
								<i class="fas fa-lightbulb"></i>
							@elseif($data->isWorkTime('p'))
								<i class="far fas-lightbulb"></i>
							@endif
						</span>
					</td>
					<td><span>+62 </span>{{$person->phoneDefault()->phone}}</td>
					<td class="w3-hide-small w3-hide-medium w3-right-align">@include('my.bauk.employee.landing_table_action')</td>
				@endforeach
				<tr>
			@else
				<td colspan="5">Belum ada data</td>
			@endif
		</tbody>
	</table>
</div> 

@endSection