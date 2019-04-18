<table class="w3-table-all">
	<thead>
		<tr class="w3-theme-l1">
			<th>Rekapitulasi</th>
			<th class="w3-center">Sampai Bulan Lalu<br>({{$summary['tableHeaders'][0]}})</th>
			<th class="w3-center">Bulan Ini<br>({{$summary['tableHeaders'][1]}})</th>
			<th class="w3-center">Sampai Bulan ini<br>({{$summary['tableHeaders'][2]}})</th>
		</tr>
	</thead>
	<tbody>
		@foreach(trans('my/bauk/attendance/hints.table.export') as $key=>$header)
		<tr>
			<td>{{$header}}</td>
			@if ($nip)
			<td class="w3-right-align">{{$summary['rows']['tillLastMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
			<td class="w3-right-align">{{$summary['rows']['thisMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
			<td class="w3-right-align">{{$summary['rows']['tillThisMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
			@else
			<td></td>
			<td></td>
			<td></td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>