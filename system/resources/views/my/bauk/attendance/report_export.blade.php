<table>
    <thead>
		<tr>
			<td colspan="8">Laporan Kehadiran</td>
		</tr>
		<tr>
			<td colspan="8">Per Tanggal: {{$start->format('d-m-Y')}} s/d {{$end->format('d-m-Y')}}</td>
		</tr>
		<tr style="background-color:#222222; color:#FEFEFE">
		@foreach($headers as $head)
			<th>{{ $head }}</th>
		@endforeach
		</tr>
    </thead>
    <tbody>
    @foreach($rows as $cells)
        <tr>
			@foreach(collect(array_keys($cells))->sort() as $index)
            <td>{{ $cells[$index] }}</td>
			@endforeach
        </tr>
    @endforeach
    </tbody>
</table>
