<div class="w3-row">
	<div class="w3-col s12 m3">	
		<div class="input-group">
			<label><i class="fas fa-font"></i></label>
			<input name="name_front_titles" 
				value="{{old('name_front_titles', $data->name_front_titles)}}"
				class="w3-input"
				placeholder="{{trans('my/bauk/employee/add.hints.name_front_titles')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('name_front_titles'))
			<label class="w3-text-red">{{$errors->first('name_front_titles')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-col s12 m6  padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-font"></i></label>
			<input name="name_full" 
				value="{{old('name_full', $data->name_full)}}"
				class="w3-input
				@if(isset($errors) && $errors->has('name_full'))
					error
				@endif
				"
				placeholder="{{trans('my/bauk/employee/add.hints.name_full')}}" 
				type="text" />
		</div>
		@if(isset($errors) && $errors->has('name_full'))
			<label class="w3-text-red">{{$errors->first('name_full')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
	<div class="w3-col s12 m3 padding-left-8 padding-none-small">	
		<div class="input-group">
			<label><i class="fas fa-font"></i></label>
			<input name="name_back_titles"
				value="{{old('name_back_titles', $data->name_back_titles)}}"
				class="w3-input"
				placeholder="{{trans('my/bauk/employee/add.hints.name_back_titles')}}"
				type="text">
		</div>
		@if(isset($errors) && $errors->has('name_back_titles'))
			<label class="w3-text-red">{{$errors->first('name_back_titles')}}</label>
		@else
			<label>&nbsp;</label>
		@endif
	</div>
</div>