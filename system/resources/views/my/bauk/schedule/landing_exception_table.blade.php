<div class="w3-row margin-top-16">
	<div class="w3-responsive">
		<table class="w3-table w3-table-all">
			<thead>
				<tr class="w3-theme">
					<th>Tanggal</th>
					<th colspan="2" align="center">Jam Kerja</th>
				</tr>
			</thead>
			<tbody>
				@forelse($schedules['exception'] as $exc)
				<tr>
					<td>{{$exc->date}}</td>
					<td>
						<i class="fas fa-sign-in-alt fa-fw margin-right-8"></i>
						{{$exc->arrival}}
					</td>
					<td>
						<i class="fas fa-sign-out-alt fa-fw margin-right-8"></i>
						{{$exc->departure}}
					</td>
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