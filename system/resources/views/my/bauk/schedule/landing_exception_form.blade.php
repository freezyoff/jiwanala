<?php 
	$schedule_exception = empty($schedule_exception)? \Session::get('schedule_exception') : $schedule_exception;
?>
<form id="exception-form" 
	name="exception-form" 
	action="{{route('my.bauk.schedule.store.exception')}}" 
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
	<input name="month" value="{{$exception_periode->month}}" type="hidden" />
	<input name="year" value="{{$exception_periode->year}}" type="hidden" />
	
	<?php 
		$end = \Carbon\Carbon::parse($exception_periode->format('Y-m-d'))->endOfMonth();
	?>
	@for($i=$exception_periode->format('Y-m-d'); $exception_periode->lessThanOrEqualTo($end); $i=$exception_periode->addDay()->format('Y-m-d'))
	<div class="w3-row padding-top-8">
		<div class="w3-col s12 m4 l3">
			<div class="input-group" style="border:none;" >
				<label style="cursor:pointer;">
					<i class="fa-square fa-fw 
						@if (old('schedule_exception.'.$i.'.check') || isset($schedule_exception[$i]))
							fas w3-text-blue
						@else
							far
						@endif
						w3-hover-text-blue"></i>
				</label>
				<label style="width:100%; cursor:pointer;">
					{{$exception_periode->format('d')}}, {{trans('calendar.days.long.'.$exception_periode->dayOfWeek)}} 
				</label>
				<input name="schedule_exception[{{$i}}][check]" 
					class="w3-hide" 
					type="checkbox" 
					@if (old('schedule_exception.'.$i.'.check'))
					checked="checked"
					@elseif (isset($schedule_exception[$i]))
					checked="checked"
					@endif
				/>
			</div>
		</div>
		<div class="w3-col s12 m4 l4">
			<div class="input-group margin-left-8 margin-none-small">
				<label><i class="fas fa-sign-in-alt fa-fw"></i></label>
				<!-- begin timepicker -->
				<?php 
					$data = [
						'name'=>'schedule_exception['.$i.'][arrival]',
						'placeholder'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'value'=>""
					];
					if (old('schedule_exception.'.$i.'.arrival')){	
						$data['value'] = old('schedule_exception.'.$i.'.arrival');
					}
					elseif (isset($schedule_exception) && isset($schedule_exception[$i])){
						$data['value'] = $schedule_exception[$i]->arrival;
					}
				?>
				@include('layouts.dashboard.components.timepicker', $data)
				<!-- end: timepicker -->
			</div>
			@if ($errors->has('schedule_exception.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-red">{{$errors->first('schedule_exception.'.$i.'.arrival')}}</label>
			@elseif (\Session::has('store.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.arrival')}}</label>
			@elseif (\Session::has('delete.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.arrival')}}</label>
			@endif
		</div>
		<div class="w3-col s12 m4 l4">
			<div class="input-group margin-left-8 margin-none-small">
				<label><i class="fas fa-sign-out-alt fa-fw"></i></label>
				<!-- begin timepicker -->
				<?php 
					$data = [
						'name'=>'schedule_exception['.$i.'][departure]',
						'placeholder'=>trans('my/bauk/schedule.hints.departureTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.departureTime'),
						'value'=>""
					];
					if (old('schedule_exception.'.$i.'.departure')){	
						$data['value'] = old('schedule_exception.'.$i.'.departure');
					}
					elseif (isset($schedule_exception) && isset($schedule_exception[$i])){
						$data['value'] = $schedule_exception[$i]->departure;
					}
				?>
				@include('layouts.dashboard.components.timepicker', $data)
				<!-- end: timepicker -->
			</div>
			@if ($errors->has('schedule_exception.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-red">{{$errors->first('schedule_exception.'.$i.'.departure')}}</label>
			@elseif (\Session::has('store.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.departure')}}</label>
			@elseif (\Session::has('delete.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.departure')}}</label>
			@endif
		</div>
	</div>
	@endFor
	<div class="w3-col s12 m12 l12" align="right">
		<button id="btnSubmit" 
			class="w3-button w3-mobile w3-blue w3-hover-blue margin-top-16"
			type="submit"
			onclick="$(this).find('i').removeClass('fa-cloud-upload-alt').addClass('button-icon-loader')">
			<i class="fas fa-cloud-upload-alt fa-fw margin-right-8"></i>
			{{trans('my/bauk/schedule.hints.save')}}
		</button>						
	</div>
	
</form>
<script>
$(document).ready(function(){
	$('form#exception-form input[type="checkbox"]').each(function(ind, item){
		$(item).click(function(event){
			event.stopPropagation(); 
		});
		
		$(item).parent().click(function(event){
			$(this).find('i')
				.toggleClass('fas')
				.toggleClass('far')
				.toggleClass('w3-text-blue');
			$(item).trigger('click');
		});
	});
});
</script>