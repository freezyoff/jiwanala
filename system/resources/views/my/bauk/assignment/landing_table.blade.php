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
			<td style="text-align:right; white-space:no-wrap;">
				@if (\Auth::guard('my')->user()->hasPermission('bauk.assignment.assign'))
				<a class="action assign" 
					title="{{"tugaskan ke ".$division->name}}"
					alt="{{"tugaskan ke ".$division->name}}"
					style="cursor:pointer"
					onclick="doAssign(this)"
					trigger-href="{{ route('my.bauk.assignment.assign',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->code]) }}">
					<i class="fas fa-arrow-circle-right"></i>
				</a>
					@if (!$hasLeader)
					<a class="action assignAs" 
						title="Tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						alt="Tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						style="cursor:pointer"
						onclick="doAssignAs(this)"
						trigger-href="{{ route('my.bauk.assignment.assign.as',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->code,'jobPositionCode'=>'2.4']) }}">
						<i class="fas fa-book-reader"></i>
					</a>
					@endif
				@endif
			</td>
			@elseif ($mode == 'release')
			<td style="text-align:right; white-space:no-wrap;">
				@if (\Auth::guard('my')->user()->hasPermission('bauk.assignment.release'))
				<a class="action release" 
					title="Pindahkan dari {{$division->name}}"
					alt="Pindahkan dari {{$division->name}}"
					style="cursor:pointer"
					onclick="doRelease(this)"
					trigger-href="{{ route('my.bauk.assignment.release',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->code]) }}">
					<i class="fas fa-arrow-circle-left"></i>
				</a>
					@if ($hasLeader && $employee->id == $leader->id)
					<a class="action releaseAs" 
						title="Bebas tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						alt="Bebas tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						style="cursor:pointer"
						onclick="doReleaseAs(this)"
						trigger-href="{{ route('my.bauk.assignment.release.as',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->code,'jobPositionCode'=>'2.4']) }}">
						<i class="fas fa-user-slash"></i>
					</a>
					@elseif (!$hasLeader)
					<a class="action assignAs" 
						title="Tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						alt="Tugaskan sebagai {{\App\Libraries\Core\JobPosition::find('2.4')->alias}} di {{$division->name}}"
						style="cursor:pointer"
						onclick="doAssignAs(this)"
						trigger-href="{{ route('my.bauk.assignment.assign.as',['employeeNIP'=>$employee->nip,'divisionCode'=>$division->code,'jobPositionCode'=>'2.4']) }}">
						<i class="fas fa-book-reader"></i>
					</a>
					@endif
				@endif
			</td>
			@endif
		</tr>
		@endforeach
	</tbody>
</table>