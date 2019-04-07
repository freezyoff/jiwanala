<h3>Summary {{$workYear->name}}</h3>
<table class="w3-table-all">
	<thead>
		<tr>
			<td style="white-space:nowrap;" align="center" rowspan="2">NIP</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">Nama</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">Hari Kerja (hari)</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">Kehadiran (%)</td>
			<td style="white-space:nowrap;" align="center" colspan="4">Kedatangan &amp; Kepulangan</td>
			<td style="white-space:nowrap;" align="center" colspan="5">Izin &amp; Cuti</td>
		</tr>
		<tr>
			<td style="white-space:nowrap;" align="center">Hadir (hari)</td>
			<td style="white-space:nowrap;" align="center">Terlambat (hari)</td>
			<td style="white-space:nowrap;" align="center">Pulang Awal (hari)</td>
			<td style="white-space:nowrap;" align="center">Tanpa Dokumen (hari)</td>
			
			<td style="white-space:nowrap;" align="center">Tidak Hadir (hari)</td>
			<td style="white-space:nowrap;" align="center">Izin Sakit (hari)</td>
			<td style="white-space:nowrap;" align="center">Izin Tugas (hari)</td>
			<td style="white-space:nowrap;" align="center">Cuti (hari)</td>
			<td style="white-space:nowrap;" align="center">Tanpa Dokumen (hari)</td>
		</tr>
	</thead>
	<tbody>
		@foreach($summaries as $nip=>$sum)
		<tr>
			<td>{{ $nip }}</td>
			<td style="white-space:nowrap;">{{ $sum['name'] }}</td>
			<td align="right">{{ $sum['workDays'] }}</td>
			<td align="right">{{ ($sum['workDays']>0)? round($sum['attends']/$sum['workDays'],2)*100 : 0 }}</td>
			<td align="right">{{ $sum['attends'] }}</td>
			<td align="right">{{ isset($sum['attends_lateArrive'])? $sum['attends_lateArrive'] : 0 }}</td>
			<td align="right">{{ isset($sum['attends_earlyDepart'])? $sum['attends_earlyDepart'] : 0 }}</td>
		</tr>
		@endforeach
	</tbody>
</table>