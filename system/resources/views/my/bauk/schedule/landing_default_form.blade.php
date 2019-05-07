<?php 
	$schedule_default = old('schedule_default', session('schedule_default', $schedule_default? $schedule_default : []));
?>
<form id="default-form" 
	name="default-form" 
	action="{{route('my.bauk.schedule.store.default')}}" 
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
	<input name="ctab" value="default" type="hidden" />
	<input name="exception_month" 
		value="{{old('exception_month', session('exception_month', $exception_month))}}" 
		type="hidden" />
	<input name="exception_year" 
		value="{{old('exception_year', session('exception_year', $exception_year))}}" 
		type="hidden" />

	@for($i=0;$i<7;$i++)
	<div class="w3-row padding-top-8">
		<div class="w3-col s12 m2 l2">
			<div class="input-group" style="border:none;" >
				<label style="cursor:pointer;">
					<i class="fa-square fa-fw 
						@if (isset($schedule_default[$i]['check']))
							fas w3-text-blue
						@else
							far
						@endif
						w3-hover-text-blue"></i>
				</label>
				<label style="width:100%; cursor:pointer;">{{trans('calendar.days.long.'.$i)}}</label>
				<input name="schedule_default[{{$i}}][check]" 
					class="w3-hide" 
					type="checkbox" 
					@if (isset($schedule_default[$i]['check']))
					checked="checked"
					@endif
				/>
			</div>
		</div>
		<div class="w3-col s12 m5 l5">
			<div class="input-group margin-left-8 margin-none-small">
				<label><i class="fas fa-sign-in-alt fa-fw"></i></label>
				<!-- begin timepicker -->
				<?php 
					$isset = isset($schedule_default[$i]) && isset($schedule_default[$i]['arrival']);
					$data = [
						'name'=>'schedule_default['.$i.'][arrival]',
						'placeholder'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.arrivalTime'),
						'value'=>$isset? $schedule_default[$i]['arrival'] : ''
					];
				?>
				@include('layouts.dashboard.components.timepicker', $data)
				<!-- end: timepicker -->
			</div>
			@if ($errors->has('schedule_default.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-red">{{$errors->first('schedule_default.'.$i.'.arrival')}}</label>
			@elseif (\Session::has('store.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.arrival')}}</label>
			@elseif (\Session::has('delete.'.$i.'.arrival'))
			<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.arrival')}}</label>
			@endif
		</div>
		<div class="w3-col s12 m5 l5">
			<div class="input-group margin-left-8 margin-none-small">
				<label><i class="fas fa-sign-out-alt fa-fw"></i></label>
				<!-- begin timepicker -->
				<?php 
				$isset = isset($schedule_default[$i]) && isset($schedule_default[$i]['arrival']);
					$data = [
						'name'=>'schedule_default['.$i.'][departure]',
						'placeholder'=>trans('my/bauk/schedule.hints.departureTime'),
						'modalTitle'=>trans('my/bauk/schedule.hints.departureTime'),
						'value'=>$isset? $schedule_default[$i]['departure'] : ''
					];
				?>
				@include('layouts.dashboard.components.timepicker', $data)
				<!-- end: timepicker -->
			</div>
			@if ($errors->has('schedule_default.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-red">{{$errors->first('schedule_default.'.$i.'.departure')}}</label>
			@elseif (\Session::has('store.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.departure')}}</label>
			@elseif (\Session::has('delete.'.$i.'.departure'))
			<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.departure')}}</label>
			@endif
		</div>
	</div>
	@endfor
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
	$('form#default-form input[type="checkbox"]').each(function(ind, item){
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
