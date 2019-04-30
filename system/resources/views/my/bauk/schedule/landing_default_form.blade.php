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

@for($i=0;$i<7;$i++)
<div class="w3-row padding-top-8 schedule-row">
	<div class="w3-col s12 m2 l2">
		<div class="input-group schedule-checkbox"		
			style="border:none;" >
			<label style="cursor:pointer;">
				<i class="fa-square fa-fw 
					@if (old('schedule.'.$i.'.check') || (isset($schedules) && isset($schedules['default'][$i])))
						fas w3-text-blue
					@else
						far
					@endif
					w3-hover-text-blue"></i>
			</label>
			<label style="width:100%; cursor:pointer;">{{trans('calendar.days.long.'.$i)}}</label>
			<input name="schedule[{{$i}}][check]" 
				class="w3-hide" type="checkbox" 
				@if (old('schedule.'.$i.'.check'))
				checked="checked"
				@elseif (isset($schedules) && isset($schedules['default'][$i]))
				checked="checked"
				@endif
			/>
		</div>
	</div>
	<div class="w3-col s12 m5 l5">
		<div class="input-group margin-left-8 margin-none-small">
			<label><i class="fas fa-sign-in-alt fa-fw"></i></label>
			<!-- begin timepicker -->
			<input id="schedule-{{$i}}-arrival" 
				name="schedule[{{$i}}][arrival][origin]" 
				@if (old('schedule.'.$i.'.arrival.origin'))
					value="{{old('schedule.'.$i.'.arrival.origin')}}"
				@elseif (isset($schedules) && isset($schedules['default'][$i]))
					value="{{$schedules['default'][$i]->arrival}}"
				@endif
				type="hidden" />
			<input id="schedule-{{$i}}-arrival-large" 
				name="schedule[{{$i}}][arrival][large]"
				class="timepicker w3-input input w3-hide-small w3-hide-medium" 
				type="text" 
				timepicker-source="#schedule-{{$i}}-arrival"
				timepicker-link="#schedule-{{$i}}-arrival-small"
				timepicker-container="#schedule-{{$i}}-arrival-container"
				readonly="readonly" 
				placeholder="{{trans('my/bauk/schedule.hints.arrivalTime')}}"/>
			<input id="schedule-{{$i}}-arrival-small" 
				name="schedule[{{$i}}][arrival][small]"
				class="timepicker w3-input input w3-hide-large" 
				type="text" 
				timepicker-source="#schedule-{{$i}}-arrival"
				timepicker-link="#schedule-{{$i}}-arrival-small"
				timepicker-modal="#schedule-{{$i}}-arrival-modal"
				timepicker-container="#schedule-{{$i}}-arrival-modal-container"
				readonly="readonly" 
				placeholder="{{trans('my/bauk/schedule.hints.arrivalTime')}}"/>
			<!-- end: timepicker -->
		</div>
		@if ($errors->has('schedule.'.$i.'.arrival.origin'))
		<label class="padding-left-16 w3-text-red">{{$errors->first('schedule.'.$i.'.arrival.origin')}}</label>
		@elseif (\Session::has('store.'.$i.'.arrival'))
		<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.arrival')}}</label>
		@elseif (\Session::has('delete.'.$i.'.arrival'))
		<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.arrival')}}</label>
		@endif
		@include('my.bauk.schedule.landing_form_timepicker_container',['icon'=>'fa-sign-in-alt','label'=>'Jam Masuk','type'=>'arrival'])
	</div>
	<div class="w3-col s12 m5 l5">
		<div class="input-group margin-left-8 margin-none-small">
			<label><i class="fas fa-sign-out-alt fa-fw"></i></label>
			<!-- begin timepicker -->
			<input id="schedule-{{$i}}-departure" 
				name="schedule[{{$i}}][departure][origin]" 
				@if (old('schedule.'.$i.'.departure.origin'))
					value="{{old('schedule.'.$i.'.departure.origin')}}"
				@elseif (isset($schedules) && isset($schedules['default'][$i]))
					value="{{$schedules['default'][$i]->departure}}"
				@endif
				type="hidden" />
			<input id="schedule-{{$i}}-departure-large" 
				name="schedule[{{$i}}][departure][large]"
				class="timepicker w3-input input w3-hide-small w3-hide-medium" 
				type="text" 
				timepicker-source="#schedule-{{$i}}-departure"
				timepicker-link="#schedule-{{$i}}-departure-small"
				timepicker-container="#schedule-{{$i}}-departure-container"
				readonly="readonly" 
				placeholder="{{trans('my/bauk/schedule.hints.departureTime')}}"/>
			<input id="schedule-{{$i}}-departure-small" 
				name="schedule[{{$i}}][departure][small]"
				class="timepicker w3-input input w3-hide-large" 
				type="text" 
				timepicker-source="#schedule-{{$i}}-departure"
				timepicker-link="#schedule-{{$i}}-departure-small"
				timepicker-modal="#schedule-{{$i}}-departure-modal"
				timepicker-container="#schedule-{{$i}}-departure-modal-container"
				readonly="readonly" 
				placeholder="{{trans('my/bauk/schedule.hints.departureTime')}}"/>
			<!-- end: timepicker -->
		</div>
		@if ($errors->has('schedule.'.$i.'.departure.origin'))
		<label class="padding-left-16 w3-text-red">{{$errors->first('schedule.'.$i.'.departure.origin')}}</label>
		@elseif (\Session::has('store.'.$i.'.departure'))
		<label class="padding-left-16 w3-text-blue">{{\Session::get('store.'.$i.'.departure')}}</label>
		@elseif (\Session::has('delete.'.$i.'.departure'))
		<label class="padding-left-16 w3-text-deep-orange">{{\Session::get('delete.'.$i.'.departure')}}</label>
		@endif
		@include('my.bauk.schedule.landing_form_timepicker_container',['icon'=>'fa-sign-out-alt','label'=>'Jam Pulang','type'=>'departure'])
	</div>
</div>
@endfor