<div class="w3-row">
	<div class="w3-col s12 m6">	
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="birth_place" 
				value="{{old('birth_place')}}"
				class="w3-input
					@if(isset($errors) && $errors->has('birth_place'))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.birth_place')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('birth_place'))
			<label class="w3-text-red">{{$errors->first('birth_place')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-col s12 m6 margin-padding-left-8">
		<input id="birth_date" type="hidden" name="birth_date" value="{{old('birth_date')}}"/>
		<div class="w3-hide-small w3-hide-medium padding-left-8">
			<div class="input-group">
				<label><i class="far fa-calendar-alt"></i></label>
				<input name="birth_date_large" 
					value="{{old('birth_date')}}"
					class="w3-input 
						@if(isset($errors) && $errors->has('birth_date'))
							error
						@endif
					"
					placeholder="{{trans('my/bauk/employee/add.hints.birth_date')}}" 
					type="text" 
					data-toggle="datepicker"/>
			</div>
			@if(isset($errors) && $errors->has('birth_date'))
				<label class="w3-text-red">{{$errors->first('birth_date')}}</label>
			@else
				<label>&nbsp;</label>
			@endif
		</div>
		<div class="w3-hide-large padding-left-8 padding-none-small">
			<div class="input-group">
				<label><i class="far fa-calendar-alt"></i></label>
				<input name="birth_date_small" 
					value="{{old('birth_date')}}"
					class="w3-input
						@if(isset($errors) && $errors->has('birth_date'))
							error
						@endif
					"
					placeholder="{{trans('my/bauk/employee/add.hints.birth_date')}}" 
					type="text" 
					data-toggle="datepicker-inline"
					onfocus="$('#datepicker-modal').show()"/>
			</div>
			@if(isset($errors) && $errors->has('birth_date'))
				<label class="w3-text-red">{{$errors->first('birth_date')}}</label>
			@else
				<label>&nbsp;</label>
			@endif
			<div id="datepicker-modal" class="w3-modal w3-display-container datepicker-modal" onclick="$(this).hide()">
				<div class="w3-modal-content w3-animate-top w3-card-4">
					<header class="w3-container w3-theme">
						<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
							onclick="$('#datepicker-modal').hide()" 
							style="font-size:20px !important">
							×
						</span>
						<h4 class="padding-top-8 padding-bottom-8">
							<i class="fas fa-calendar-alt"></i>
							<span style="padding-left:12px;">Calendar</span>
						</h4>
					</header>
					<div id="datepicker-inline-container" class="datepicker-inline-container"></div>
				</div>
			</div>
		</div>
	</div>
</div>