<div class="w3-tag w3-red margin-bottom-8">{{ trans('my/bauk/attendance/hints.tags.upload_failed') }}</div>
<div class="w3-responsive">
	<table class="w3-table w3-table-all">
	<thead>
		<tr class="w3-{{ $report['imported']==1? 'indigo' :  $report['imported']==0? 'amber' : 'brown' }}">
			<td>Kolom</td>
			<td>Data Impor</td>
			<td>Kesalahan</td>
		</tr>
	</thead>
	<tbody>
	@foreach(array_except($report,['imported']) as $key=>$value)
		<tr>
			<td>{{ ucwords(str_replace('_',' ',$key)) }}</td>
			<td>{{ $value['data'] }}</td>
			<td>
			@if ($value['error'])
				<span class="w3-text-red">{{$value['error']}}</span>
			@elseif (!$value['error'])
				<span class="w3-tag w3-yellow">{{trans('my/bauk/attendance/hints.tags.upload_item_ignored')}}</span>
			@endif
			</td>
		</tr>
	@endforeach
	</tbody>
	</table>
</div>