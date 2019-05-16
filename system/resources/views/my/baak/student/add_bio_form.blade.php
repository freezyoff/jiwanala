<!-- BEGIN: Form Student bio -->
<div class="w3-row">
	<div class="w3-col s12 m6 l6">
		<div class="input-group @error('student.kk') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="student[kk]" type="text" value="{{old('student.kk','')}}" 
				placeholder="{{trans($trans.'.hints.kk')}}" 
				class="w3-input"/>
		</div>
		@error('student.kk')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.kk')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group @error('student.nik') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="student[nik]" type="text" value="{{old('student.nik','')}}" 
				placeholder="{{trans($trans.'.hints.nik')}}" 
				class="w3-input"/>
		</div>
		@error('student.nik')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.nik')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	<div class="w3-col s12 m6 l6">
		<div class="input-group @error('student.name_full') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="student[name_full]" type="text" value="{{old('student.name_full','')}}" 
				placeholder="{{trans($trans.'.hints.name', ['attr'=>trans($trans.'.student')])}}"
				class="w3-input"/>
		</div>
		@error('student.name_full')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.name_full')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group @error('student.gender') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<?php 
				$opts = [
					'name'=>			'student[gender]',
					'dropdown'=>		['layouts.dashboard.components.select_gender_items',[]],
					'modalTitle'=>		trans($trans.'.hints.gender'),
					'placeholder'=>		trans($trans.'.hints.gender'),
					'value' =>			old('student.gender')
				];
			?>
			@include('layouts.dashboard.components.select',$opts)
		</div>
		@error('student.gender')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.gender')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	<div class="w3-col s12 m4 l4">
		<div class="input-group @error('student.birth_place') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<input name="student[birth_place]" type="text" value="{{old('student.birth_place','')}}" 
				placeholder="{{trans($trans.'.hints.birth_place')}}" 
				class="w3-input"/>
		</div>
		@error('student.birth_place')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.birth_place')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>

	<div class="w3-col s12 m8 l8 padding-left-8 padding-none-small">
		<div class="input-group @error('student.birth_date') error @enderror">
			<label><i class="far fa-address-card fa-fw"></i></label>
			<?php 
				$opt = [
					'name'=>'student[birth_date]',
					'value'=>old('student.birth_date'),
					'placeholder'=>trans($trans.'.hints.birth_date'),
					'modalTitle'=>trans($trans.'.hints.birth_date'),
				];
			?>
			@include('layouts.dashboard.components.datepicker', $opt)
		</div>
		@error('student.birth_date')
		<label class="w3-text-red padding-left-8">{{$errors->first('student.birth_date')}}</label>
		@else
		<label>&nbsp;</label>
		@enderror
	</div>
</div>

<div class="w3-row">
	@for($i=0;$i<count(old('student.email',[0,1]));$i++)
		<div class="w3-col s12 m6 l6 @if($i>0) padding-left-8 padding-none-small @endif">
			<div class="input-group">
				<label><i class="far fa-address-card fa-fw"></i></label>
				<input name="student[email][{{$i}}]" type="text" value="{{old('student.email.'.$i,'')}}" 
					placeholder="{{trans($trans.'.hints.email')}}" 
					class="w3-input"/>
			</div>
			@error('student.email.'.$i)
			<label class="w3-text-red padding-left-8">{{$errors->first('student.email.'.$i)}}</label>
			@else
			<label>&nbsp;</label>
			@enderror
		</div>
	@endfor
</div>

<div class="w3-row">
	<div class="input-group @error('student.address') error @enderror">
		<label><i class="far fa-address-card fa-fw"></i></label>
		<?php 	
			$opts = [
				'id'=>				'student-address',
				'name'=>			'student[address]',
				'dropdown'=> [
					'my.baak.student.student_property_association',
					['type'=> trans('my/baak/student/add.hints.address')]
				],
				'modalTitle'=>		trans($trans.'.hints.address'),
				'placeholder'=>		trans($trans.'.hints.address'),
				'value' =>			old('student.address')
			];
		?>
		@include('layouts.dashboard.components.select',$opts)
	</div>
	@error('student.address')
	<label class="w3-text-red padding-left-8">{{$errors->first('student.address')}}</label>
	@else
	<label>&nbsp;</label>
	@enderror
</div>
<script>
$(document).ready(function(){
	$('#student-address').on('change', function(){
		if ($(this).val() == 'gu'){
			$('#guardian-container').show();
		}
		else{
			$('#guardian-container').hide();
		}
	}).trigger('change');
});
</script>
<!-- END: Form -->