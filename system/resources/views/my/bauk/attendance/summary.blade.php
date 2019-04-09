<h3>Summary {{$workYear->name}}</h3>
<table class="w3-table-all" border="1">
	<thead>
		<tr>
			<td style="white-space:nowrap;" align="center" rowspan="2">NIP</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">Nama</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">Hari Kerja (hari)</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">{!! str_replace(" ","<br>","Hadir (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">{!! str_replace(" ","<br>","Tidak Hadir (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center" rowspan="2">{!! str_replace(" ","<br>","Kehadiran (%)") !!}</td>
			<td style="white-space:nowrap;" align="center" colspan="3">Terlambat & Pulang Awal</td>
			<td style="white-space:nowrap;" align="center" colspan="3">Tidak Finger</td>
			<td style="white-space:nowrap;" align="center" colspan="4">Izin &amp; Cuti</td>
		</tr>
		<tr>
			{{-- terlambat & pulang awal --}}
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Terlambat (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Pulang Awal (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Tanpa Dokumen (hari)") !!}</td>

			{{-- tidak finger datang & pulang --}}
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Tidak Finger Datang hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Tidak Finger Pulang (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Tanpa Dokumen (hari)") !!}</td>
			
			{{-- tidak hadir --}}
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Izin Sakit (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Izin Tugas (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Cuti (hari)") !!}</td>
			<td style="white-space:nowrap;" align="center">{!! str_replace(" ","<br>","Tanpa Dokumen (hari)") !!}</td>
		</tr>
	</thead>
	<tbody>
		@foreach($summary as $nip=>$sum)
		<tr>
			<td>{{ $nip }}</td>
			<td style="white-space:nowrap;">{{ $sum['name'] }}</td>
			<td align="right">{{ $sum['work_days'] }}</td>
			<td align="right">{{ $sum['attends'] }}</td>
			<td align="right">{{ $sum['notAttends'] }}</td>
			<td align="right">{{ ($sum['work_days']>0)? round($sum['attends']/$sum['work_days'],2)*100 : "" }}</td>
			
			{{-- terlambat & pulang awal --}}
			<td align="right">{{ isset($sum['attends_lateArrive'])? $sum['attends_lateArrive'] : "" }}</td>
			<td align="right">{{ isset($sum['attends_earlyDepart'])? $sum['attends_earlyDepart'] : "" }}</td>
			<td align="right">{{ isset($sum['attends_lateOrEarlyConsent'])? $sum['attends_lateOrEarlyConsent'] : "" }}</td>
			
			{{-- tidak finger datang & pulang --}}
			<td align="right">{{ isset($sum['attends_noArrival'])? $sum['attends_noArrival'] : "" }}</td>
			<td align="right">{{ isset($sum['attends_noDeparture'])? $sum['attends_noDeparture'] : "" }}</td>
			<td align="right">{{ isset($sum['attends_noArrivalOrDepartureConsent'])? $sum['attends_noArrivalOrDepartureConsent'] : "" }}</td>
			
			{{-- tidak hadir --}}
			<td align="right">{{ isset($sum['consents_sick'])? $sum['consents_sick'] : "" }}</td>
			<td align="right">{{ isset($sum['consents_duty'])? $sum['consents_duty'] : "" }}</td>
			<td align="right">{{ isset($sum['consents_others'])? $sum['consents_others'] : "" }}</td>
			<td align="right">{{ isset($sum['consents_noConsent'])? $sum['consents_noConsent'] : "" }}</td>
		</tr>
		@endforeach
	</tbody>
</table>