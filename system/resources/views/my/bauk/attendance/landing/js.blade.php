<script>
App.UI.search = {
	init:function(){
		App.UI.search.formSearchNIP.init();
		App.UI.search.text.init();
		App.UI.search.date.init();
	}
};

App.UI.search.formSearchNIP = {
	container: $('#searchNIP'),	
	ajaxSearch: function (event) {
		event.preventDefault();
		
		$.ajax({
			type: $(this).attr('method'),
			url: $(this).attr('action'),
			data: $(this).serialize(),
			beforeSend: App.UI.search.text.dropdown.onAjaxSend,
			complete: App.UI.search.text.dropdown.onAjaxComplete,
			success: App.UI.search.text.dropdown.onAjaxSuccess,
			error: App.UI.search.text.dropdown.onAjaxFailed,
		});
	},
	init:function(){
		this.container.submit(this.ajaxSearch);
		//if (App.UI.search.text.container.val() != ''){
		//	this.container.trigger('submit');		
		//}
	}
};

App.UI.search.syncValue = function(key, value){
	$('#searchHistory>input[name="'+key+'"]').val(value).trigger('change');
};

App.UI.search.text = {
	container: App.UI.search.formSearchNIP.container.find('input[name="nip"]'),
	label: App.UI.search.formSearchNIP.container.find('label[name="name"]'),
	value: function(nip, label){ 
		$(this.container).val(nip);
		$(this.label).html(label).parents('.w3-col').show();
	},
	init:function(){
		label = $(this.label);
		label.parents('.w3-col').hide();
		$('#searchNIP').find('input[name="nip"]')
			.on('keyup', $.debounce(400, function(e){
				if (e.keyCode == 27 || e.keyCode == 38) { //escape & up arrow
					App.UI.search.text.dropdown.hide();
				}
				else if (e.keyCode == 40){	//down arrow
					App.UI.search.text.dropdown.show();
				}
				else {
					$('#searchNIP').submit();
				}
				
				label.parents('.w3-col').hide();
			}))
			.on('focus click', function(){
				$(this).next().html('');
				App.UI.search.text.dropdown.show();
			});
	}
};

App.UI.search.text.dropdown = {
	container: $('#searchNIP-dropdown>ul'),
	empty: function(){ App.UI.search.text.dropdown.container.empty(); },
	dropdown: function(){
		$(window).resize(App.UI.search.text.dropdown.onWindowResize);
	},
	itemClicked: function(event){
		event.stopPropagation();
		nip = $(this).find('div.nip').html();
		App.UI.search.text.value(nip, $(this).find('div.name').html());
		App.UI.search.text.dropdown.hide();
		App.UI.search.syncValue('ctab', 'tab-item-summary');
		App.UI.search.syncValue('nip', nip);
	},
	onAjaxSend: function(){
		$('#searchNIP').find('.input-group>input[name="nip"]').prev().children()
			.removeClass('fa-user-circle').addClass('button-icon-loader');
	},
	onAjaxComplete: function(){
		$('#searchNIP').find('.input-group>input[name="nip"]').prev().children()
			.removeClass('button-icon-loader').addClass('fa-user-circle');
	},
	onAjaxSuccess: function (data) {
		var dropdown = App.UI.search.text.dropdown;
		dropdown.empty();
		dropdown.addItems(data);
		if (dropdown.container.children().length==1) {
			dropdown.container.children().trigger('click');
		}
		else{
			dropdown.show();
		}
	},
	onAjaxFailed: function (data) {
		$('#searchNIP-dropdown').hide();
	},
	createItem: function(json){
		var name = json.name_front_titles==null? '': json.name_front_titles;
			name += json.name_full==null? '' : ' ' + json.name_full;
			name += json.name_back_titles==null? '' : ' ' + json.name_back_titles;
		var li = $('<li style="display:table-row; cursor:pointer"></li>').hover(App.UI.search.text.dropdown.onHoverIn, App.UI.search.text.dropdown.onHoverOut);
			li.append($('<div class="nip" style="display:table-cell; padding:8px 16px; width:100px;">'+ json.nip +'</div>'));
			li.append($('<div class="name" style="display:table-cell; padding:8px 16px; white-space: nowrap;">'+ name +'</div>'));
		return li.click(App.UI.search.text.dropdown.itemClicked);
	},
	addItems: function(items){ 
		$.each(items, function(index, item){ 
			var li = App.UI.search.text.dropdown.createItem(item);
			App.UI.search.text.dropdown.container.append( li ); 			
		});
	},
	onWindowResize: function(){
		this.show();
	},
	show: function(){ 
		var list = App.UI.search.text.dropdown.container.find('li');
		if (list.length>0){ 
			App.UI.search.text.dropdown.container.parent()
				.css('visiblity','hidden')
				.show()
				.width(App.UI.search.text.dropdown.calcListWidth())
				.css('visiblity','visible');
		}
		else{ App.UI.search.text.dropdown.hide(); }
	},
	hide: function(){ 
		App.UI.search.text.dropdown.container.parent().hide(); 
	},
	calcListWidth: function(){
		var offset = 10;
		var min = App.UI.search.text.dropdown.container.attr('min-width');
			min = min? min : App.UI.search.text.dropdown.container.attr('min-width', App.UI.search.text.dropdown.container.width()).width();
		return Math.max(
			App.UI.search.text.dropdown.container.parent().width(), 
			App.UI.search.text.dropdown.container.width() + offset
		);
	}
};

App.UI.search.date = {
	options: {},
	events:{
		pick: function(){
			App.UI.search.syncValue('ctab', 'tab-item-details');
			App.UI.search.syncValue($(this).attr('name'), $(this).val());
		}
	},
	init:function(){
		$('[role="select"]').select().on('select.pick', App.UI.search.date.events.pick);
	}
};

$(document).ready(function(){ 
	App.UI.search.init();
	
	@if ($nip)
		if (App.UI.search.text.container.val() != ''){
			App.UI.search.text.value('{{$nip}}', '{{$name}}')
		}
	@endif
});
</script>

<script>
App.UI.tabs = {
	showItem: function(id){
		$('#tabs-container').children().addClass('w3-hide');
		$(id).removeClass('w3-hide');
	},
	higlightHeader: function(el){
		$('#tabs-header').children().removeClass('w3-light-grey');
		$(el).addClass('w3-light-grey');
	},
	init: function(){
		var ctab = '#{{$ctab}}';
		if (ctab == '#'){
			$('#tabs-header').children().first().trigger('click');
		}
		else{
			$(ctab).trigger('click');
		}
	}
};

$(document).ready(function(){ 
	App.UI.tabs.init();
});
</script>

<script>
App.UI.search.formHistory = {
	init: function(){
		$('#searchHistory>input[name="nip"]').on('change', App.UI.search.formHistory.onChange);
		$('#searchHistory>input[name="month"]').on('change', App.UI.search.formHistory.onChange);
		$('#searchHistory>input[name="year"]').on('change', App.UI.search.formHistory.onChange);
	},
	onChange: function(){
		$('#searchHistory').trigger('submit');
	}
};

$(document).ready(function(){ 
	App.UI.search.formHistory.init();
});
</script>