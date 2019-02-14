@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/landing.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-col s12 m6 l6 padding-right-8 padding-none-small">
		<h4>Hari Libur Selanjutnya</h4>
		<table class="w3-table w3-table-all">
			<thead>
				<tr>
					<th>Tanggal</th>
					<th>Hari Libur</th>
				</tr>
			</thead>
			<tbody>
				@foreach($currentMonthHolidays as $row)
				<tr>
					<?php 
						$range = $row->getDateRange();
					?>
					<td>
						{{$range[0]->format('d')}}
						{{trans('calendar.months.long.'.$range[0]->format('n'))}}
						@if ($range[0] != $range[1])
							<span>-</span>
							{{$range[1]->format('d')}}
							{{trans('calendar.months.long.'.$range[1]->format('n'))}}
						@endif
					</td>
					<td>{{$row->name}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	@include('my.bauk.landing_holidays')
</div>
@endSection

@section('html.body.scripts')
@parent
@endSection