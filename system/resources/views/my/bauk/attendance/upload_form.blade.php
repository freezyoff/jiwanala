<form action="{{route('my.bauk.attendance.upload')}}" name="import" method="POST" enctype="multipart/form-data">
	@csrf
	<div class="w3-container">
		<div class="input-group">
			<label><i class="fas fa-calendar-alt fa-fw"></i></label>
			<input id="dateformat" 
				name="dateformat" 
				type="hidden" 
				placeholder="{{trans('my/bauk/attendance/hints.modal.dateformat')}}"
				value="{{old('dateformat')}}"
				select-role="dropdown"
				select-dropdown="#dateformat-dropdown" 
				select-modal="#dateformat-modal"
				select-modal-container="#dateformat-modal-container" />
		</div>
		@include('my.bauk.attendance.upload_dateformat_dropdown_modal')
		@if ($errors->has('dateformat'))
			<label class="w3-text-red padding-left-8">{{$errors->first('dateformat')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-container">
		<div class="input-group">
			<label><i class="fas fa-clock fa-fw"></i></label>
			<input id="timeformat" name="timeformat" 
				type="hidden" 
				placeholder="{{trans('my/bauk/attendance/hints.modal.timeformat')}}"
				value="{{old('timeformat')}}"
				select-role="dropdown"
				select-dropdown="#timeformat-dropdown" 
				select-modal="#timeformat-modal"
				select-modal-container="#timeformat-modal-container" />
		</div>
		@include('my.bauk.attendance.upload_timeformat_dropdown_modal')
		@if ($errors->has('timeformat'))
			<label class="w3-text-red padding-left-8">{{$errors->first('timeformat')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-container">
		<div class="input-group">
			<label><i class="fas fa-upload fa-fw"></i></label>
			<label for="file" style="width:100%"><span class="w3-text-grey">{{trans('my/bauk/attendance/hints.buttons.upload-file')}}</span></label>
			<input id="file" name="file" type="file" style="display:none" accept=".csv" />
		</div>
		@if ($errors->has('file'))
			<label class="w3-text-red padding-left-8">{!! $errors->first('file') !!}</label>
		@elseif (\Session::has('invalid'))
			<label class="w3-text-red padding-left-8">{!! array_values(\Session::get('invalid'))[0] !!}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-row w3-container padding-bottom-8">
		<div class="w3-col m6 l6 w3-hide-small">&nbsp;</div>
		<div class="w3-col s12 m6 l6">
			<button class="w3-button w3-hover-blue w3-blue" 
				type="submit"
				style="width:100%;"
				onclick="$(this).find('i').attr('class', 'button-icon-loader')">
				<i class="fas fa-cloud-upload-alt fa-fw"></i>
				<span class="padding-left-8">{{trans('my/bauk/attendance/hints.buttons.upload-file')}}</span>
			</button>		
		</div>
	</div>
</form>