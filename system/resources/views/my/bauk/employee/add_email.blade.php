<!--<div class="w3-row">-->
	<div class="w3-col s12 m6 l6 
		@if($index % 2 == 1)
			padding-left-8
		@endif
	">
		<div class="input-group
			@if(isset($errors) && $errors->has('email.'.$index))
				error
			@endif
			">
			<label><i class="fas fa-envelope"></i></label>
			<input name="email[]" type="text" 
				value="{{old('email.'.$index)}}"
				placeholder="{{trans('my/bauk/employee/add.hints.email')}}" 
				class="input w3-input"
				style="min-width:0"/>
			@if($index > 0)
			<label style="cursor:pointer" onclick="$(this).parent().parent().remove();">
				<i class="fas fa-minus-square"></i>
			</label>
			@endif
		</div>
		@if(isset($errors) && $errors->has('email.'.$index))
			<label class="w3-text-red">{{$errors->first('email.'.$index)}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
<!--</div>-->