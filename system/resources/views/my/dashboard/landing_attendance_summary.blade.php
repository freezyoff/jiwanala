<div class="w3-responsive">
	<table id="attendance-summary" class="w3-table-all">
		<thead>
			<tr class="w3-theme-l1">
				<th>Rekapitulasi</th>
				<th class="w3-center" nowrap>Sampai<br>Bulan Lalu<br>{!!str_replace(' ','<br>',$summary['tableHeaders'][0])!!}</th>
				<th class="w3-center" nowrap>Bulan Ini<br>{{$summary['tableHeaders'][1]}}</th>
				<th class="w3-center" nowrap>Sampai<br>Bulan ini<br>{!!str_replace(' ','<br>',$summary['tableHeaders'][2])!!}</th>
			</tr>
		</thead>
		<tbody>
			@foreach(trans('my/bauk/attendance/hints.table.export') as $key=>$header)
			@if ($key == 'attendance')
				@continue
			@endif
			<tr>
				<td>{!!$header!!}</td>
				@if ($nip)
				<td class="w3-right-align" nowrap>{{$summary['rows']['tillLastMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
				<td class="w3-right-align" nowrap>{{$summary['rows']['thisMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
				<td class="w3-right-align" nowrap>{{$summary['rows']['tillThisMonth']->get($key)}}{!!$key=='attendance'? '' : '<span class="padding-left-16">'!!}</td>
				@else
				<td></td>
				<td></td>
				<td></td>
				@endif
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
<style>
@media (max-width: 600px){
	table#attendance-summary thead tr th {font-size:12px;}
	table#attendance-summary tbody tr td {font-size:12px;}
}
</style>