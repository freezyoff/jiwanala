<table>
    <thead>
		<tr class="w3-indigo w3-text-white">
			<th rowspan="2">NO</th>
			<th rowspan="2">NIP</th>
			<th rowspan="2">Nama</th>
			<th rowspan="2">Hari Kerja</th>
			<th rowspan="2">Hadir</th>
			<th rowspan="2">Tidak Hadir</th>
			<th rowspan="2">Kehadiran</th>
			<th colspan="3">Terlambat &amp; Pulang Awal</th>
			<th colspan="3">Tidak Finger</th>
			<th colspan="4">Izin &amp; Cuti</th>
		</tr>
		<tr class="w3-indigo w3-text-white">	
			{{-- terlambat & pulang awal --}}
			<th>Terlambat</th>
			<th>Pulang Awal</th>
			<th>Tanpa Dokumen</th>

			{{-- tidak finger datang & pulang --}}
			<th>Tidak Finger Datang</th>
			<th>Tidak Finger Pulang</th>
			<th>Tanpa Dokumen</th>
			
			{{-- tidak hadir --}}
			<th>Izin Sakit</th>
			<th>Izin Tugas</th>
			<th>Cuti</th>
			<th>Tanpa Dokumen</th>
		</tr>
		<tr class="w3-blue">
			<th></th>
			<th></th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(%)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
			<th>(hari)</th>
		</tr>
	</thead>
    <tbody>
		@foreach($summary as $nip=>$sum)
		<tr>
			<td>{{ $loop->iteration }}</td>
			<td>{{ $nip }}</td>
			<td style="text-align:left !important;">{{ $sum['name'] }}</td>
			<td>{{ $sum['work_days'] }}</td>
			<td>{{ $sum['attends'] }}</td>
			<td>{{ $sum['notAttends'] }}</td>
			<td>{{ ($sum['work_days']>0)? round($sum['attends']/$sum['work_days'],2)*100 : "" }}</td>
			
			{{-- terlambat & pulang awal --}}
			<td>{{ isset($sum['attends_lateArrive'])? $sum['attends_lateArrive'] : "" }}</td>
			<td>{{ isset($sum['attends_earlyDepart'])? $sum['attends_earlyDepart'] : "" }}</td>
			<td>{{ isset($sum['attends_lateOrEarlyConsent'])? $sum['attends_lateOrEarlyConsent'] : "" }}</td>
			
			{{-- tidak finger datang & pulang --}}
			<td>{{ isset($sum['attends_noArrival'])? $sum['attends_noArrival'] : "" }}</td>
			<td>{{ isset($sum['attends_noDeparture'])? $sum['attends_noDeparture'] : "" }}</td>
			<td>{{ isset($sum['attends_noArrivalOrDepartureConsent'])? $sum['attends_noArrivalOrDepartureConsent'] : "" }}</td>
			
			{{-- tidak hadir --}}
			<td>{{ isset($sum['consents_sick'])? $sum['consents_sick'] : "" }}</td>
			<td>{{ isset($sum['consents_duty'])? $sum['consents_duty'] : "" }}</td>
			<td>{{ isset($sum['consents_others'])? $sum['consents_others'] : "" }}</td>
			<td>{{ isset($sum['consents_noConsent'])? $sum['consents_noConsent'] : "" }}</td>
		</tr>
		@endforeach
	</tbody>
</table>