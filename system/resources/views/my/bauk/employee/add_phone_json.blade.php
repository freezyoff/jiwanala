'<div class="w3-row">'+
	'<div class="w3-col s12 m9 l9">'+
		'<div class="input-group">'+
			'<label>'+
				'<i class="fas fa-phone-square"></i>'+
				'<span class="padding-left-8">+62</span>'+
			'</label>'+
			'<input name="phone[]" type="text" value="" '+
				'placeholder="{{trans('my/bauk/employee/add.hints.phone')}}" '+
				'class="input w3-input"'+
				'style="min-width:0"/>'+
			'<button class="w3-button w3-hover-none w3-hover-text-red w3-hide-medium w3-hide-large" '+
				'onclick="UI.phone.remove($(this).parent().parent().parent())" '+
				'type="button" '+
				'title="hapus telepon/handphone">'+
				'<i class="fas fa-minus-square"></i>'+
			'</button>'+
		'</div>'+
		'<label>&nbsp;</label>'+
	'</div>'+
	'<div class="w3-col s12 m3 l3 padding-left-8 padding-none-small">'+
		'<div style="justify-content:left" '+
			'class="input-group">'+
			'<label><i class="fas fa-external-link-square-alt"></i></label>'+
			'<input name="extension[]" type="text" value="" '+
				'placeholder="{{trans('my/bauk/employee/add.hints.extension')}}" '+
				'class="input w3-input"'+
				'style="min-width:0;"/>'+
			'<button class="w3-button w3-hover-none w3-hover-text-red w3-hide-small" '+
				'onclick="UI.phone.remove($(this).parent().parent().parent())" '+
				'type="button" '+
				'title="hapus telepon/handphone">'+
				'<i class="fas fa-minus-square"></i>'+
			'</button>'+
		'</div>'+
		'<label>&nbsp;</label>'+
	'</div>'+
'</div>'