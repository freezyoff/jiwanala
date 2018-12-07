<div class="w3-row">
	<input name="phone_id[{{$index}}]" type="hidden" value="{{old('phone_id.'.$index, isset($phone->id)? $phone->id : '')}}" />
	<div class="w3-col s12 m9 l9">
		<div class="input-group
			@if(isset($errors) && $errors->has('phone.'.$index))
				error
			@endif
			">
			<label>+62</label>
			<input name="phone[{{$index}}]" 
				type="text" 
				value="{{old('phone.'.$index, isset($phone->phone)? $phone->phone : '')}}" 
				placeholder="{{trans('my/bauk/employee/add.hints.phone')}}" 
				class="input w3-input"
				style="min-width:0"/>
			@if($index > 0)
				<button class="w3-button w3-hover-none w3-hover-text-red w3-hide-medium w3-hide-large" 
					onclick="UI.phone.remove($(this).parent().parent().parent())" 
					type="button" 
					title="hapus telepon/handphone">
					<i class="fas fa-minus-square"></i>
				</button>
			@endif
		</div>
		@if(isset($errors) && $errors->has('phone.'.$index))
			<label class="w3-text-red">{{$errors->first('phone.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-col s12 m3 l3 padding-left-8 padding-none-small">
		<div class="input-group
			@if(isset($errors) && $errors->has('extension.'.$index))
				error
			@endif
			">
			<label>Ext:</label>
			<input name="extension[{{$index}}]" type="text" 
				value="{{old('extension.'.$index, isset($phone->extension)? $phone->extension : '')}}" 
				placeholder="{{trans('my/bauk/employee/add.hints.extension')}}" 
				class="input w3-input"
				style="min-width:0;"/>
			@if($index > 0)
				<button class="w3-button w3-hover-none w3-hover-text-red w3-hide-small" 
					onclick="UI.phone.remove($(this).parent().parent().parent())" 
					type="button" 
					title="hapus telepon/handphone">
					<i class="fas fa-minus-square"></i>
				</button>
			@endif
		</div>
		@if(isset($errors) && $errors->has('extension.'.$index))
			<label class="w3-text-red">{{$errors->first('extension.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
</div>