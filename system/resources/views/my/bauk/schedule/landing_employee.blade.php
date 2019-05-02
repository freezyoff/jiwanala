<div class="w3-row">
	<div class="w3-col s12 m4 l4">
		<div class="input-group">
			<label><i class="fas fa-user fa-fw"></i></label>
			<label id="search-nip-label" class="w3-input">
				@if (old('employee_nip', isset($employee)? $employee->nip : false))
					{{old('employee_nip', isset($employee)? $employee->nip : false)}}
				@else
					<span style="color:grey">{{trans('my/bauk/schedule.hints.nip')}}</span>
				@endif
			</label>
			
		</div>
	</div>
	<div class="w3-col s12 m8 l8">
		<div class="input-group margin-left-8 margin-none-small">
			<label><i class="fas fa-font faw-fw"></i></label>
			<label id="search-name-label" class="w3-input">
				@if (old('employee_name', isset($employee)? $employee->getFullName(' ') : false))
					{{old('employee_name', isset($employee)? $employee->getFullName(' ') : false)}}
				@else
					<span style="color:grey">{{trans('my/bauk/schedule.hints.name')}}</span>
				@endif
			</label>
		</div>
	</div>
</div>