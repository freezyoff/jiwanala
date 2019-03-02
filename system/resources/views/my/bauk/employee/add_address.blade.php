<div class="w3-row">
	<div class="w3-col s12 m12 l12">
		<div class="input-group 
			@if(isset($errors) && $errors->has('address.'.$index))
				error
			@endif			
		">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="address[]" 
				value="{{old('address.'.$index)}}"
				class="input w3-input"
				placeholder="{{trans('my/bauk/employee/add.hints.address')}}"
				type="text">
			@if ($index > 0)
				<button class="w3-button w3-hover-none w3-hover-text-red" 
					onclick="UI.address.remove($(this).parent().parent().parent())" 
					type="button" 
					title="hapus alamat">
					<i class="fas fa-minus-square"></i>
				</button>
			@endif
		</div>
		@if(isset($errors) && $errors->has('address.'.$index))
			<label class="w3-text-red">{{$errors->first('address.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m2 l2 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="neighbourhood[]" 
				value="{{old('neighbourhood.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('neighbourhood.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.neighbourhood')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('neighbourhood.'.$index))
			<label class="w3-text-red">{{$errors->first('neighbourhood.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m2 l2 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="hamlet[]" 
				value="{{old('hamlet.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('hamlet.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.hamlet')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('hamlet.'.$index))
			<label class="w3-text-red">{{$errors->first('hamlet.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="urban[]" 
				value="{{old('urban.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('urban.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.urban')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('urban.'.$index))
			<label class="w3-text-red">{{$errors->first('urban.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="sub_disctrict[]" 
				value="{{old('sub_disctrict.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('sub_disctrict.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.sub_district')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('sub_disctrict.'.$index))
			<label class="w3-text-red">{{$errors->first('sub_disctrict.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small padding-none-medium">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="district[]" 
				value="{{old('district.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('district.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.district')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('district.'.$index))
			<label class="w3-text-red">{{$errors->first('district.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="province[]" 
				value="{{old('province.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('province.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.province')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('province.'.$index))
			<label class="w3-text-red">{{$errors->first('province.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-map-marker-alt"></i></label>
			<input name="post_code[]" 
				value="{{old('post_code.'.$index)}}"
				class="w3-input
					@if(isset($errors) && $errors->has('post_code.'.$index))
						error
					@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.post_code')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('post_code.'.$index))
			<label class="w3-text-red">{{$errors->first('post_code.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
</div>