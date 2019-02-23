<div class="w3-tag w3-indigo">{{ trans('my/bauk/attendance/hints.tags.upload_success') }}</div>
@foreach(['tanggal','nip'] as $key)
<div>
	<span style="min-width:100px;display:inline-block;padding:4px 4px 4px 16px">
		{{$key=='nip'? strtoupper($key) : ucfirst($key)}}
	</span>
	<span style="min-width:100px;display:inline-block;padding:4px 4px 4px 16px">
		: {{$report[$key]['import']}} {{$report[$key]['record']}}
	</span>
</div>
@endforeach
<div class="w3-responsive">
	<table class="w3-table w3-table-all">
	<thead>
		<tr class="w3-{{ $report['imported']==1? 'indigo' :  $report['imported']==0? 'amber' : 'brown' }}">
			<td></td>
			<td>Data Awal</td>
			<td>Data Impor</td>
			<td>Tindakan</td>
		</tr>
	</thead>
	<tbody>
	@foreach(array_except($report,['nip','tanggal','imported']) as $key=>$value)
		<tr>
			<td>{{ ucwords(str_replace('_',' ',$key)) }}</td>
			<td>{{ $value['record'] }}</td>
			<td>{{ $value['import'] }}</td>
			<td>
			@if ($value['overwrite'])
				<span class="w3-tag w3-indigo">{{trans('my/bauk/attendance/hints.tags.upload_item_uploaded')}}</span>
			@elseif (!$value['overwrite'])
				<span class="w3-tag w3-yellow">{{trans('my/bauk/attendance/hints.tags.upload_item_ignored')}}</span>
			@endif
			</td>
		</tr>
	@endforeach
	</tbody>
	</table>
</div>