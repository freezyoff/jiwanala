<div class="w3-row w3-container">
	<div class="">
		<div class="input-group padding-none-small">
			<label><i class="fas fa-font"></i></label>
			<input name="name" type="text" class="w3-input" 
				value="{{old('name')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.name')}}"/>
		</div>
		@if($errors->has('name'))
		<label class="w3-text-red">{{$errors->first('name')}}</label>
		@else
		<label>&nbsp;</label>
		@endif
	</div>
</div>
<div class="w3-row w3-container">
	<div class="w3-col s12 m6 l6 padding-right-8 padding-none-small">
		<div class="input-group padding-none-small">
			<label><i class="fas fa-calendar"></i></label>
			<input id="startlarge" 
				name="startlarge" 
				type="text" 
				class="w3-input w3-hide-small w3-hide-medium" 
				value="{{old('start')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.start')}}"
				datepicker-role="dropdown"
				datepicker-value="input[name='start']"
				datepicker-link="input[name='startsmall']" />
			<input id="startsmall" 
				name="startsmall" 
				type="text" 
				class="w3-input w3-hide-large" 
				value="{{old('start')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.start')}}"
				datepicker-role="modal"
				datepicker-modal="#startsmall-modal"
				datepicker-container="#startsmall-modal-container" 
				datepicker-value="input[name='start']" 
				datepicker-link="input[name='startlarge']" />
		</div>
		<div id="startsmall-modal" 
			class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
			onclick="$(this).hide()">
			<div class="w3-modal-content w3-animate-top w3-card-4">
				<header class="w3-container w3-theme">
					<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
						onclick="$('#jn-modal').hide()" 
						style="font-size:20px !important">
						×
					</span>
					<h4 class="padding-top-8 padding-bottom-8">
						<i class="fas fa-calendar-alt"></i>
						<span style="padding-left:12px;">{{trans('my/bauk/holiday.hints.start')}}</span>
					</h4>
				</header>
				<div id="startsmall-modal-container" class="datepicker-inline-container"></div>
			</div>
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
			<input id="endlarge" 
				name="endlarge" 
				type="text" 
				class="w3-input w3-hide-small w3-hide-medium" 
				value="{{old('end')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.end')}}"
				datepicker-role="dropdown"
				datepicker-value="input[name='end']"
				datepicker-link="input[name='endsmall']" />
			<input id="endsmall" 
				name="endsmall" 
				type="text" 
				class="w3-input w3-hide-large" 
				value="{{old('end')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.end')}}"
				datepicker-role="modal"
				datepicker-modal="#endsmall-modal"
				datepicker-container="#endsmall-modal-container" 
				datepicker-value="input[name='end']" 
				datepicker-link="input[name='endlarge']" />
		</div>
		<div id="endsmall-modal" 
			class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
			onclick="$(this).hide()">
			<div class="w3-modal-content w3-animate-top w3-card-4">
				<header class="w3-container w3-theme">
					<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
						onclick="$('#endsmall-modal').hide()" 
						style="font-size:20px !important">
						×
					</span>
					<h4 class="padding-top-8 padding-bottom-8">
						<i class="fas fa-calendar-alt"></i>
						<span style="padding-left:12px;">{{trans('my/bauk/holiday.hints.end')}}</span>
					</h4>
				</header>
				<div id="endsmall-modal-container" class="datepicker-inline-container"></div>
			</div>
		</div>
		@if($errors->has('end'))
		<label class="w3-text-red">{{$errors->first('end')}}</label>
		@else
		<label>&nbsp;</label>
		@endif
	</div>
</div>
<div class="w3-row w3-container">
	<div class="">
		<div class="input-group padding-none-small">
			<label><i class="fas fa-redo fa-fw"></i></label>
			<input id="repeat" name="repeat" type="text" class="w3-input" 
				value="{{old('repeat')}}" 
				placeholder="{{trans('my/bauk/holiday.hints.repeat')}}"
				select-role="dropdown"
				select-dropdown="#repeat-dropdown" 
				select-modal="#repeat-modal"
				select-modal-container="#repeat-modal-container"/>
		</div>
		<div id="repeat-dropdown" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium">
			<ul class="w3-ul w3-hoverable">
				<li style="cursor:pointer;">
					<a class="w3-text-theme w3-mobile" 
						select-role="item" 
						select-value="1">
						Setiap Tahun
					</a>
				</li>
				<li style="cursor:pointer;">
					<a class="w3-text-theme w3-mobile" 
						select-role="item" 
						select-value="0">
						Tahun ini saja
					</a>
				</li>
			</ul>
		</div>
		<div id="repeat-modal" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
			<div class="w3-modal-content w3-animate-top w3-card-4">
				<header class="w3-container w3-theme">
					<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
						onclick="$('#repeat-modal').hide()" 
						style="font-size:20px !important">
						×
					</span>
					<h4 class="padding-top-8 padding-bottom-8">
						<i class="fas fa-calendar-alt"></i>
						<span style="padding-left:12px;">{{trans('my/bauk/holiday.hints.end')}}</span>
					</h4>
				</header>
				<div id="repeat-modal-container" class="datepicker-inline-container">
					<div class="w3-bar-block" style="width:100%">
						<ul class="w3-ul w3-hoverable">
							<li style="cursor:pointer;">
								<a class="w3-text-theme w3-mobile" 
									select-role="item" 
									select-value="1">
									Setiap Tahun
								</a>
							</li>
							<li style="cursor:pointer;">
								<a class="w3-text-theme w3-mobile" 
									select-role="item" 
									select-value="0">
									Tahun ini saja
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		@if($errors->has('repeat'))
		<label class="w3-text-red">{{$errors->first('repeat')}}</label>
		@else
		<label>&nbsp;</label>
		@endif
	</div>
</div>
<div class="w3-row w3-container">
	<footer class="padding-bottom-16" style="margin-top:8px;text-align:right;">
		<button class="w3-button w3-hover-red w3-red" 
			type="button"
			onclick="$(this).find('i').removeClass('fa-times').addClass('button-icon-loader'); document.location='{{route('my.bauk.holiday.landing')}}';">
			<i class="fas fa-times fa-fw"></i>
			<span class="padding-left-8">{{trans('my/bauk/holiday.hints.back')}}</span>
		</button>
		<button class="w3-button w3-hover-blue w3-blue margin-left-8"
			type="submit"
			onclick="$(this).find('i').removeClass('fa-cloud-upload-alt').addClass('button-icon-loader')">
			<i class="fas fa-cloud-upload-alt fa-fw"></i>
			<span class="padding-left-8">{{trans('my/bauk/holiday.hints.save')}}</span>
		</button>
	</footer>
</div>