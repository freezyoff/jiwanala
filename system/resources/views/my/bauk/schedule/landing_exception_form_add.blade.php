<form action="{{route('my.bauk.schedule.store.exception')}}" 
	method="post" 
	class="w3-container w3-border w3-border-grey" 
	style="display:none;">
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
	
	<div class="w3-row padding-top-8">
		<div class="w3-col s12 m6 l6">
			<div class="input-group">
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
			@endif
		</div>
		<div class="w3-col s12 m6 l6">
			<div class="input-group margin-left-8 margin-none-small padding-top-8 padding-none-medium padding-none-large">
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
			<label class="w3-text-red margin-left-8">{{$errors->first('end')}}</label>
			@endif
		</div>
	</div>
	<div class="w3-row margin-top-8">
		<div class="w3-col s12 m6 l6">
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
			@if($errors->has('arrival'))
			<label class="w3-text-red">{{$errors->first('arrival')}}</label>
			@endif
		</div>
		<div class="w3-col s12 m6 l6">
			<div class="input-group margin-left-8 margin-none-small padding-top-8 padding-none-medium padding-none-large">
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
			@if($errors->has('departure'))
			<label class="w3-text-red margin-left-8">{{$errors->first('departure')}}</label>
			@endif
		</div>
	</div>
	<div class="w3-row margin-top-bottom-16">
		<div class="w3-right-align">
			<button class="w3-button w3-mobile w3-red w3-hover-red" type="button"
				onclick="$(this).parents('form').hide()">
				<i class="fas fa-times fa-fw margin-right-8"></i>
				Batal
			</button>
			<button class="w3-button w3-mobile w3-blue w3-hover-blue margin-left-8-medium margin-left-8-large margin-top-8-small" type="submit">
				<i class="fas fa-cloud-upload-alt fa-fw margin-right-8"></i>
				Submit
			</button>
		</div>
	</div>
</form>