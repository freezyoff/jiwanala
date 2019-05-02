<form action="{{route('my.bauk.schedule.store.exception')}}" method="post">
	@csrf
	
	<input name="ctab" value="exception" type="hidden" />
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
	
	<div class="w3-row">
		<div class="w3-col s12 m6 l6 padding-right-8 padding-none-small">
			<div class="input-group padding-none-small">
				<label><i class="fas fa-calendar"></i></label>
				<?php 
					$dtStart = [
						'id'=> str_replace('-','',\Illuminate\Support\Str::uuid()),
						'name'=>'start',
						'placeholder'=>trans('my/bauk/holiday.hints.start'),
						'modalTitle'=>trans('my/bauk/holiday.hints.start'),
						'modalIconClass'=>'fas fa-calendar-alt',
					];
				?>
				@include('layouts.dashboard.components.datepicker', $dtStart)
			</div>
			@if($errors->has('start'))
			<label class="w3-text-red">{{$errors->first('start')}}</label>
			@else
			<label>&nbsp;</label>
			@endif
		</div>
		<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
			<div class="input-group padding-none-small">
				<label><i class="fas fa-calendar"></i></label>
				<?php 
					$data = [
						'startDateLimiter'=> $dtStart['id'],
						'name'=>'end',
						'placeholder'=>trans('my/bauk/holiday.hints.end'),
						'modalTitle'=>trans('my/bauk/holiday.hints.end'),
						'modalIconClass'=>'fas fa-calendar-alt',
					];
				?>
				@include('layouts.dashboard.components.datepicker', $data)
			</div>
			@if($errors->has('end'))
			<label class="w3-text-red">{{$errors->first('end')}}</label>
			@else
			<label>&nbsp;</label>
			@endif
		</div>
	</div>
	<div class="w3-row">
		<div class="w3-col s12 m6 l6 padding-right-8 padding-none-small">
			<div class="input-group">
				<label><i class="fas fa-sign-in-alt fa-fw"></i></label>
				<?php 
					$data = [
						'name'=>'arrival',
						'placeholder'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'modalIconClass'=>'fas fa-sign-in-alt fa-fw',
					];
				?>
				@include('layouts.dashboard.components.timepicker', $data)
			</div>
		</div>
		<div class="w3-col s12 m6 l6 padding-right-8 padding-none-small">
			<div class="input-group">
				<label><i class="fas fa-sign-out-alt fa-fw"></i></label>
				<?php 
					$data = [
						'name'=>'departure',
						'placeholder'=>trans('my/bauk/schedule.hints.departureTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.departureTime'),
						'modalIconClass'=>'fas fa-sign-out-alt fa-fw',
					];
				?>
				@include('layouts.dashboard.components.timepicker', $data)
			</div>
		</div>
	</div>
	<button type="submit">Submit</button>
</form>