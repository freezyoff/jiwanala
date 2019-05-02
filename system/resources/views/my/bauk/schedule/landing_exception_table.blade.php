<div class="w3-row">
	<div class="w3-responsive">
		<table class="w3-table w3-table-all">
			<thead>
				<tr class="w3-theme">
					<th>Tanggal</th>
					<th>Jam Kerja</th>
				</tr>
			</thead>
			<tbody>
				@forelse($schedules['exception'] as $exc)
				<tr>
					<td>{{Carbon::parse($exc->date)->format('Y-m-d')}}</td>
					<td>{{$exc->arrival}}</td>
					<td>{{$exc->departure}}</td>
				</tr>
				@empty
				<tr>
					<td colspan="2">Belum ada data</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>