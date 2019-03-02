<?php
	$workTimeCollection = ['f'=>'Full Time','p'=>'Part Time'];
	$workTimeKey = in_array(old('work_time'),['f','p'])? old('work_time') : '';
	$workTimeLabel = in_array(old('work_time'),['f','p'])? $workTimeCollection[$workTimeKey] : '';
?>
<div class="w3-row">
	<div class="w3-col s12 m6">	
		<div class="input-group
			@if(isset($errors) && $errors->has('work_time'))
				error
			@endif
			">
			<label><i class="fas fa-hand-point-right"></i></label>
			<input name="work_time" type="hidden" value="{{ $workTimeKey }}" />
			<input name="work_time_small" 
				value="{{ $workTimeLabel }}"
				class="input w3-input w3-hide-large"
				placeholder="{{trans('my/bauk/employee/add.hints.work_time')}}"
				type="text"
				readonly="readonly" />
			<button class="w3-button w3-hover-none w3-hover-text-blue w3-hide-large"
				type="button">
				<i class="fas fa-chevron-down"></i>
			</button>
			<input name="work_time_large" 
				value="{{ $workTimeLabel }}"
				class="input w3-input w3-hide-small w3-hide-medium"
				placeholder="{{trans('my/bauk/employee/add.hints.work_time')}}"
				type="text"
				readonly="readonly">
			<button class="w3-button w3-hover-none w3-hover-text-blue w3-hide-small w3-hide-medium"
				type="button" />
				<i class="fas fa-chevron-down"></i>
			</button>
		</div>
		<div id="worktime-dropdown" class="w3-dropdown-content w3-bar-block w3-card">
			<ul class="w3-ul">
				<li class="w3-hover-light-grey" style="cursor:pointer;">
					<a class="w3-text-theme w3-mobile" 
						data-value="f">
						<i class="fas fa-hands-helping"></i>
						<span style="padding-left:12px">Full Time</span>
					</a>
				</li>
				<li class="w3-hover-light-grey" style="cursor:pointer">
					<a class="w3-text-theme w3-mobile" 
						data-value="p">
						<i class="fas fa-handshake"></i>
						<span style="padding-left:12px">Part Time</span>
					</a>
				</li>
			</ul>
		</div>
		<div id="worktime-modal" class="w3-modal w3-display-container" onclick="$(this).hide()">
			<div class="w3-modal-content w3-animate-top w3-card-4">
				<header class="w3-container w3-theme">
					<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
						onclick="$('#worktime-modal').hide()" 
						style="font-size:20px !important">
						×
					</span>
					<h4 class="padding-top-8 padding-bottom-8">
						<i class="fas fa-clock"></i>
						<span style="padding-left:12px;">{{trans('my/bauk/employee/add.hints.work_time')}}</span>
					</h4>
				</header>
				<div class="w3-bar-block" style="width:100%">
					<ul class="w3-ul" style="font-size:1.2em">
						<li class="w3-hover-light-grey" style="cursor:pointer;">
							<a class="w3-text-theme w3-mobile" 
								data-value="f">
								<i class="fas fa-hands-helping"></i>
								<span style="padding-left:12px">Full Time</span>
							</a>
						</li>
						<li class="w3-hover-light-grey" style="cursor:pointer">
							<a class="w3-text-theme w3-mobile" 
								data-value="p">
								<i class="fas fa-handshake"></i>
								<span style="padding-left:12px">Part Time</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		@if(isset($errors) && $errors->has('work_time'))
			<label class="w3-text-red">{{$errors->first('work_time')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-col s12 m6 margin-padding-left-8">
		<input id="registered_at" type="hidden" name="registered_at" value="{{old('registered_at')}}"/>
		<div class="w3-hide-small w3-hide-medium padding-left-8">
			<div class="input-group">
				<label><i class="far fa-calendar-alt"></i></label>
				<input name="registered_at_large" 
					value="{{old('registered_at', \Carbon\Carbon::now(session()->get('timezone'))->format('d-m-Y') )}}"
					class="w3-input 
						@if(isset($errors) && $errors->has('registered_at'))
							error
						@endif
					"
					placeholder="{{trans('my/bauk/employee/add.hints.registered_at')}}" 
					type="text" 
					data-toggle="datepicker-registeredAt"/>
			</div>
			@if(isset($errors) && $errors->has('registered_at'))
				<label class="w3-text-red">{{$errors->first('registered_at')}}</label>
			@else
				<label>&nbsp;</label>
			@endif
		</div>
		<div class="w3-hide-large padding-left-8 padding-none-small">
			<div class="input-group">
				<label><i class="far fa-calendar-alt"></i></label>
				<input name="registered_at_small" 
					value="{{old('registered_at', \Carbon\Carbon::now(session()->get('timezone'))->format('d-m-Y') )}}"
					class="w3-input
						@if(isset($errors) && $errors->has('registered_at'))
							error
						@endif
					"
					placeholder="{{trans('my/bauk/employee/add.hints.registered_at')}}" 
					type="text" 
					data-toggle="datepicker-inline-registeredAt"
					onfocus="$('#datepicker-modal-registeredAt').show()"/>
			</div>
			@if(isset($errors) && $errors->has('registered_at'))
				<label class="w3-text-red">{{$errors->first('registered_at')}}</label>
			@else
				<label>&nbsp;</label>
			@endif
			<div id="datepicker-modal-registeredAt" class="w3-modal w3-display-container datepicker-modal" onclick="$(this).hide()">
				<div class="w3-modal-content w3-animate-top w3-card-4">
					<header class="w3-container w3-theme">
						<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
							onclick="$('#jn-modal').hide()" 
							style="font-size:20px !important">
							×
						</span>
						<h4 class="padding-top-8 padding-bottom-8">
							<i class="fas fa-calendar-alt"></i>
							<span style="padding-left:12px;">Calendar</span>
						</h4>
					</header>
					<div id="datepicker-inline-container-registeredAt" class="datepicker-inline-container"></div>
				</div>
			</div>
		</div>
	</div>
</div>