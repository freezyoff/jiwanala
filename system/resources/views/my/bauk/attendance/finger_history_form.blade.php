<form id="submitForm" method="post" action="{{ $post_action }}">
	@csrf
	<input name="employee_id" value="{{$employee->id}}" type="hidden" />
	<input name="employee_nip" value="{{$employee->nip}}" type="hidden" />
	<input name="date" value="{{$date->format('Y-m-d')}}" type="hidden" />
	<input name="attendance_record_id" value="{{$attendance? $attendance->id : ''}}" type="hidden" />
	<input name="back_action" value="{{$back_action}}" type="hidden" />
	<div class="w3-row w3-container">
		<div class="w3-row">
			<div class="w3-col s12 m6 l6">
				<div class="input-group">
					<label><i class="fas fa-user-circle fa-fw"></i></label>
					<label style="width:100%">{{$employee->nip}}</label>
				</div>
				<label>&nbsp;</label>
			</div>
			<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
				<div class="input-group">
					<label><i class="fas fa-font fa-fw"></i></label>
					<label style="width:100%; overflow:hidden">{{$employee->getFullName()}}</label>
				</div>
				<label>&nbsp;</label>
			</div>
		</div>			
	</div>
	<div class="w3-row w3-container">
		<div class="w3-col s12 m6 l6">
			<div class="input-group">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<label style="width:100%">
					{{trans('calendar.days.long.'.($date->dayOfWeek))}}, &nbsp;
					{{$date->day}}&nbsp;
					{{trans('calendar.months.long.'.($date->month-1))}}&nbsp;
					{{$date->year}}
				</label>
			</div>
			<label>&nbsp;</label>
		</div>
		@foreach([1=>'Masuk',2=>'Keluar',3=>'Keluar',4=>'Keluar'] as $item=>$label)
			<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
				<div class="input-group">
					<label>
						<i class="fas fa-sign-{{$item>1? 'out' : 'in'}}-alt fa-fw"></i>
					</label>
					<input id="time{{$item}}" name="time{{$item}}" type="hidden" value="{{ $attendance? $attendance->{'time'.$item} : "" }}" />
					<input id="time{{$item}}-large" name="time{{$item}}-large" 
						value=""
						class="timepicker w3-input input w3-hide-small w3-hide-medium" 
						type="text" 
						timepicker-source="#time{{$item}}"
						timepicker-link="#time{{$item}}-small"
						timepicker-container="#time{{$item}}-container"
						readonly="readonly" 
						placeholder="{{trans('my/bauk/attendance/hints.buttons.finger-time').' '.$label}}"/>
					<input id="time{{$item}}-small" name="time{{$item}}-small" 
						value=""
						class="timepicker w3-input input w3-hide-large" 
						type="text" 
						timepicker-source="#time{{$item}}"
						timepicker-link="#time{{$item}}-large"
						timepicker-modal="#time{{$item}}-modal"
						timepicker-container="#time{{$item}}-modal-container"
						readonly="readonly" 
						placeholder="{{trans('my/bauk/attendance/hints.buttons.finger-time').' '.$label}}"/>
					<label onclick="$(this).prev().val('')" style="cursor:pointer;" class="w3-hover-text-red">
						<i class="fas fa-times fa-fw" style="padding-top:4px"></i>
					</label>
				</div>
				<div class="w3-dropdown-click w3-hide-small" style="display:block">
					<div id="time{{$item}}-container" class="w3-dropdown-content w3-bar-block w3-border"></div>
				</div>
				<div id="time{{$item}}-modal" 
					class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
					onclick="$(this).hide()">
					<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:300px; margin:auto;">
						<header class="w3-container w3-theme">
							<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
								onclick="$('#time{{$item}}-modal').hide()">
								×
							</h4>
							<h4 class="padding-top-8 padding-bottom-8">
								<i class="fas fa-sign-{{$item>1? 'out' : 'in'}}-alt fa-fw"></i>
								<span style="padding-left:12px;">
									{{str_replace(':attribute',ucfirst($label), trans('my/bauk/attendance/hints.modal.finger'))}}
								</span>
							</h4>
						</header>
						<div id="time{{$item}}-modal-container" class="datepicker-inline-container"></div>
					</div>
				</div>
				@if ($errors->has('time'.$item))
					<label class="w3-text-red padding-left-8">{{$errors->first('time'.$item)}}</label>
				@else
					<label>&nbsp;</label>
				@endif
			</div>
		@endforeach
	</div>
	<div class="w3-row padding-left-16 padding-right-16 w3-hide-medium w3-hide-large">
		<div class="w3-col s12 m4 l7" align="right">
			<button class="w3-button w3-red w3-hover-red w3-mobile" 
				onclick="$(this).find('i').attr('class','button-icon-loader-red'); document.location='{{$back_action}}'"
				type="button">
				<i class="fas fa-times"></i>
				<span class="padding-left-8">Batal</span>
			</button>
			<button class="w3-button w3-blue w3-hover-blue w3-hover-none w3-mobile margin-top-8" 
				onclick="$(this).find('i').attr('class','button-icon-loader'); $('#submitForm').submit()"
				type="button">
				<i class="fas fa-cloud-upload-alt"></i>
				<span class="padding-left-8">Simpan</span>
			</button>
		</div>
	</div>
	<div class="w3-row padding-left-16 padding-right-16 w3-hide-small">
		<div class="w3-col" align="right">
			<button class="w3-button w3-red w3-hover-red w3-mobile" 
				onclick="$(this).find('i').attr('class','button-icon-loader-red'); document.location='{{$back_action}}'"
				type="button">
				<i class="fas fa-times"></i>
				<span class="padding-left-8">Batal</span>
			</button>
			<span class="margin-right-8"></span>
			<button class="w3-button w3-blue w3-hover-blue w3-hover-none" 
				onclick="$(this).find('i').attr('class','button-icon-loader'); $('#submitForm').submit()"
				type="button">
				<i class="fas fa-cloud-upload-alt"></i>
				<span class="padding-left-8">Simpan</span>
			</button>
		</div>
	</div>
</form>
<form id="backForm" method="post" action="{{ $post_action }}">

</form>