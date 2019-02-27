<table>
    <thead>
		<tr style="background-color:#222222; color:#FEFEFE">
		@foreach($headers as $head)
			<th>{{ $head }}</th>
		@endforeach
		</tr>
    </thead>
    <tbody>
    @foreach($rows as $cells)
        <tr>
			@foreach($cells as $value)
            <td>{{ $value }}</td>
			@endforeach
        </tr>
    @endforeach
    </tbody>
</table>
