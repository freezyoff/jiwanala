<table class="w3-table w3-table-all">
	<thead>
		<tr class="w3-theme">
			<td>NIP</td>
			<td>Nama</td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		@foreach($employees as $employee)
		<tr>
			<td>{{ $employee->nip }}</td>
			<td>{{ $employee->getFullName() }}</td>
			@if ($mode == 'assign')
			<td style="text-align:right; white-space: nowrap;">
				@if (\Auth::user()->hasPermission('bauk.assignment.assign'))
				<a class="action assign" 
					title="{{"tugaskan ke ".$division->name}}"
					alt="{{"tugaskan ke ".$division->name}}"
					style="cursor:pointer"
					onclick="doAssign(this)"
					trigger-href="{{ route('my.bauk.assignment.assign',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->id]) }}">
					<i class="fas fa-arrow-circle-left"></i>
				</a>
				@endif
			</td>
			@elseif ($mode == 'release')
			<td style="text-align:right; white-space: nowrap;">
				@if (\Auth::user()->hasPermission('bauk.assignment.release'))
				<a class="action release" 
					title="Pindahkan dari {{$division->name}}"
					alt="Pindahkan dari {{$division->name}}"
					style="cursor:pointer"
					onclick="doRelease(this)"
					trigger-href="{{ route('my.bauk.assignment.release',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->id]) }}">
					<i class="fas fa-arrow-circle-right"></i>
				</a>
				@endif
			</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>