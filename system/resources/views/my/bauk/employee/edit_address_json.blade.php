'<div class="w3-row">'+
	'<div class="w3-col s12 m12 l12">'+
		'<div class="input-group">'+
			'<input name="address[]" '+
				'class="w3-input input" '+
				'placeholder="{{trans('my/bauk/employee/add.hints.address')}}" '+
				'type="text">'+
			'<button class="w3-button w3-hover-none w3-hover-text-red" '+
				'onclick="UI.address.remove($(this).parent().parent().parent())" '+
				'type="button" '+
				'title="hapus alamat">'+
				'<i class="fas fa-minus-square"></i>'+
			'</button>'+
		'</div>'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m2 l2 padding-none-small">'+
		'<input name="neighbourhood[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.neighbourhood')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m2 l2 padding-left-8 padding-none-small">'+
		'<input name="hamlet[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.hamlet')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">'+
		'<input name="urban[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.urban')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">'+
		'<input name="sub_disctrict[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.sub_district')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small padding-none-medium">'+
		'<input name="district[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.district')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">'+
		'<input name="province[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.province')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">'+
		'<input name="post_code[]" '+
			'class="w3-input" '+
			'placeholder="{{trans('my/bauk/employee/add.hints.post_code')}}" '+
			'type="text">'+
		'<label>&nbsp;</label>'+
	'</div>'+
'</div>'