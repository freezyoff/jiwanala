<div class="w3-row">
	<input name="address_id[{{$index}}]" type="hidden" value="{{old('address_id.'.$index, isset($address->id)? $address->id : '')}}" />
	<div class="w3-col s12 m12 l12">
		<div class="input-group 
			@if(isset($errors) && $errors->has('address.'.$index))
				error
			@endif			
		">
			<input name="address[{{$index}}]" 
				value="{{old('address.'.$index, isset($address->address)? $address->address : '')}}" 
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
		<input name="neighbourhood[{{$index}}]" 
			value="{{old('neighbourhood.'.$index, isset($address->neighbourhood)? $address->neighbourhood : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('neighbourhood.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.neighbourhood')}}"
			type="text">
		@if(isset($errors) && $errors->has('neighbourhood.'.$index))
			<label class="w3-text-red">{{$errors->first('neighbourhood.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m2 l2 padding-left-8 padding-none-small">
		<input name="hamlet[{{$index}}]" 
			value="{{old('hamlet.'.$index, isset($address->hamlet)? $address->hamlet : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('hamlet.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.hamlet')}}"
			type="text">
		@if(isset($errors) && $errors->has('hamlet.'.$index))
			<label class="w3-text-red">{{$errors->first('hamlet.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<input name="urban[{{$index}}]" 
			value="{{old('urban.'.$index, isset($address->urban)? $address->urban : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('urban.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.urban')}}"
			type="text">
		@if(isset($errors) && $errors->has('urban.'.$index))
			<label class="w3-text-red">{{$errors->first('urban.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<input name="sub_disctrict[{{$index}}]" 
			value="{{old('sub_disctrict.'.$index, isset($address->sub_disctrict)? $address->sub_disctrict : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('sub_disctrict.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.sub_district')}}"
			type="text">
		@if(isset($errors) && $errors->has('sub_disctrict.'.$index))
			<label class="w3-text-red">{{$errors->first('sub_disctrict.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small padding-none-medium">
		<input name="district[{{$index}}]" 
			value="{{old('district.'.$index, isset($address->district)? $address->district : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('district.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.district')}}"
			type="text">
		@if(isset($errors) && $errors->has('district.'.$index))
			<label class="w3-text-red">{{$errors->first('district.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<input name="province[{{$index}}]" 
			value="{{old('province.'.$index, isset($address->province)? $address->province : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('province.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.province')}}"
			type="text">
		@if(isset($errors) && $errors->has('province.'.$index))
			<label class="w3-text-red">{{$errors->first('province.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
	<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
		<input name="post_code[{{$index}}]" 
			value="{{old('post_code.'.$index, isset($address->post_code)? $address->post_code : '')}}"
			class="w3-input
				@if(isset($errors) && $errors->has('post_code.'.$index))
					error
				@endif
			"
			placeholder="{{trans('my/bauk/employee/add.hints.post_code')}}"
			type="text">
		@if(isset($errors) && $errors->has('post_code.'.$index))
			<label class="w3-text-red">{{$errors->first('post_code.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif	
	</div>
</div>