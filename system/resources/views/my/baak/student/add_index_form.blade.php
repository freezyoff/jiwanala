<!-- BEGIN: Form Student id -->
<div class="w3-row">
	<div class="w3-col s12 m6 l6">
		<div class="input-group @error('student.nis') error @enderror">
			<label><i class="fas fa-id-card-alt fa-fw"></i></label>
			<input name="student[nis]" type="text" value="{{old('student.nis','')}}" 
				placeholder="{{trans($trans.'.hints.nis')}}" 
				class="w3-input"/>
		</div>
		@error('student.nis')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.nis')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group @error('student.nisn') error @enderror">
			<label><i class="fas fa-id-card fa-fw"></i></label>
			<input name="student[nisn]" type="text" value="{{old('student.nisn','')}}" 
				placeholder="{{trans($trans.'.hints.nisn')}}" 
				class="w3-input"/>
		</div>
		@error('student.nisn')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.nisn')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	<div class="w3-col s12 m6 l6">
		<div class="input-group @error('student.register_type') error @enderror">
			<label><i class="fas fa-calendar-day fa-fw"></i></label>
			<?php 
				$opts = [
					'name'=>			'student[register_type]',
					'dropdown'=>		['my.baak.student.register_dropdown',[]],
					'modalTitle'=>		trans($trans.'.hints.register_type'),
					'placeholder'=>		trans($trans.'.hints.register_type'),
					'value' =>			old('student.register_type')
				];
			?>
			@include('layouts.dashboard.components.select',$opts)
		</div>
		@error('student.register_type')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.register_type')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group @error('student.register_at') error @enderror">
			<label><i class="fas fa-calendar-day fa-fw"></i></label>
			<?php 
				$opts = [
					'name'=>			'student[register_at]',
					'placeholder'=>		trans($trans.'.hints.register_at'),
					'value' =>			old('student.register_at')
				];
			?>
			@include('layouts.dashboard.components.datepicker',$opts)
		</div>
		@error('student.register_at')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.register_at')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	
	</div>
</div>

<!-- END: Form -->