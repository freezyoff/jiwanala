@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.summary')])

@section('dashboard.main')
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans('my/bauk/attendance/pages.subtitles.summary')}} {{$workYear->name}}</h4>
		</header>
		<div class="w3-container">
			{{ $summary->links() }}
			<div class="w3-responsive">
				@include('my.bauk.attendance.summary_table')
			</div>
			{{ $summary->links() }}
		</div>
	</div>
@endSection

@section('html.head.styles')
@parent
<style>
table.w3-table-all>thead>tr>td,
table.w3-table-all>thead>tr>th {white-space:nowrap; vertical-align:middle; text-align:center; border:1px solid #fefefe;}

table.w3-table-all>tbody>tr>td,
table.w3-table-all>tbody>tr>th {white-space:nowrap; vertical-align:middle; text-align:right; border:1px solid #aeaeae;}

.fixme {
    position: relative;
    left: expression( ( 20 + ( ignoreMe2 = document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft ) ) + 'px' );
}
</style>
@endSection