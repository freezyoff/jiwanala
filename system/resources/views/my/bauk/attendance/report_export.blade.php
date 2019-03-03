<table>
    <thead>
		<tr>
			<td colspan="{{$count($headers)}}">Laporan Kehadiran</td>
		</tr>
		<tr>
			<td colspan="{{$count($headers)}}">Per Tanggal: {{$start->format('d-m-Y')}} s/d {{$end->format('d-m-Y')}}</td>
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
