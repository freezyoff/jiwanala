<form id="exception-search-form" 
	name="exception-search-form"
	action="{{route('my.bauk.schedule.landing')}}" 
	method="post">
	@csrf
	
	<input name="employee_id" 
		value="{{old('employee_id', isset($employee)? $employee->id : '')}}"
		type="hidden" />
	<input name="employee_nip" 
		value="{{old('employee_nip', isset($employee)? $employee->nip : '')}}"
		type="hidden" />
	<input name="employee_name" 
		value="{{old('employee_name', isset($employee)? $employee->getFullName(' ') : '')}}"
		type="hidden" />
	<input name="ctab" value="exception" type="hidden" />
	
	@include('my.bauk.schedule.landing_employee')
	<div class="w3-row">
		<div class="w3-col s12 m6 l6">
			<div class="input-group padding-top-8">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<?php 
					$monthID = str_replace('-','',\Illuminate\Support\Str::uuid());
					$dropdown = [
						'id'		=> $monthID,
						'name'		=> 'exception_month',
						'value'		=> old('exception_month', session('exception_month', $exception_month)),
						'dropdown'	=> ['layouts.dashboard.components.select_date_items', ['month'=>true]],
						'modalTitle'=> ucfirst(trans('my/bauk/attendance/pages.subtitles.month')),
					];
				?>
				@include('layouts.dashboard.components.select', $dropdown)
			</div>
		</div>
		<div class="w3-col s12 m6 l6">
			<div class="input-group margin-left-8 margin-none-small padding-top-8">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<?php 
					$yearID = str_replace('-','',\Illuminate\Support\Str::uuid());
					$dropdown = [
						'id'		=> $yearID,
						'name'		=> 'exception_year',	
						'value'		=> old('exception_year', session('exception_year', $exception_year)),
						'dropdown'	=> ['layouts.dashboard.components.select_date_items', ['year'=>true]],
						'modalTitle'=> ucfirst(trans('my/bauk/attendance/pages.subtitles.month')),
					];
				?>
				@include('layouts.dashboard.components.select', $dropdown)
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){
	$('input#{{$monthID}}, input#{{$yearID}}').on('select.pick', function(){
		$('form#exception-search-form').trigger('submit');
	});
});
</script>