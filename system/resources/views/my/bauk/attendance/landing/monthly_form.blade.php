<form id="monthly-form" action="{{route('my.bauk.attendance.search.employee')}}" method="post">
	@csrf
	<div class="padding-top-8">
		<div class="w3-row">
			<div class="w3-col s12 m6 l4">
				<div class="input-group">
					<label><i class="fas fa-calendar fa-fw"></i></label>
					<input id="month" 
						name="month" 
						value="{{isset($month)? $month : now()->format('n')}}"
						type="text" 
						class="w3-input" 
						role="select"
						select-dropdown="#month-dropdown"
						select-modal="#month-modal"
						select-modal-container="#month-modal-container" />
				</div>
				@include('my.bauk.attendance.landing.employee_form_month_dropdown')
				@include('my.bauk.attendance.landing.employee_form_month_modal')
				<label>&nbsp;</label>
			</div>
			<div class="w3-col s12 m6 l4 padding-left-8 padding-none-small">
				<div class="input-group">
					<label><i class="fas fa-calendar fa-fw"></i></label>
					<input id="year" name="year" type="text" class="w3-input" 
						value="{{isset($year)? $year : now()->format('Y')}}" 
						role="select"
						select-dropdown="#year-dropdown"
						select-modal="#year-modal"
						select-modal-container="#year-modal-container" />
				</div>
				@include('my.bauk.attendance.landing.employee_form_year_dropdown')
				@include('my.bauk.attendance.landing.employee_form_year_modal')
				<label>&nbsp;</label>
			</div>
		</div>
		<div class="w3-row">
			<div class="w3-col s12 m6 l4">
				<div class="input-group" style="justify-content:start">
					<label><i class="fas fa-user-circle fa-fw"></i></label>
					<input id="searchNIP-nip" 
						name="nip" 
						value="{{$nip}}"
						class="w3-input input" 
						type="text" 
						placeholder="NIP" 
						autocomplete="off" />
				</div>
				<div class="w3-dropdown-click w3-hide-small" style="display:block">
					<div id="searchNIP-dropdown" 
						class="w3-card w3-dropdown-content w3-bar-block w3-border" 
						style="width:100%; max-height:400px; overflow:hidden scroll;">
						<ul class="w3-ul w3-hoverable" style="display:table; list-style:none; width:100%"></ul>
					</div>
				</div>
				<label>&nbsp;</label>
			</div>
			<div class="w3-col s12 m6 l5 padding-left-8 padding-none-small">
				<div class="input-group" style="justify-content:start">
					<label><i class="fas fa-font fa-fw"></i></label>
					<label name="name" for="searchNIP-nip" style="width:100%"></label>
				</div>
			</div>
		</div>
	</div>
</form>
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

App.UI.search.formSearchAttendance = {
	container: $('#searchAttendance'),
	submitForm: function(){
		var year = $('input[name="year"]').val();
		var month = $('input[name="month"]').val();
		var nip = App.UI.search.text.container.val();
		if (App.UI.search.text.label.is(':visible') && year && month){
			document.location = '{{route("my.bauk.attendance.landing")}}/'+nip+'/'+year+'/'+month;
		}
	}
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
		App.UI.search.text.value($(this).find('div.nip').html(), $(this).find('div.name').html());
		App.UI.search.text.dropdown.hide();
		App.UI.search.formSearchAttendance.submitForm();
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
			App.UI.search.formSearchAttendance.submitForm();
		}
	},
	init:function(){
		$('[role="select"]').select().on('select.pick', App.UI.search.date.events.pick);
	}
};
</script>
<script>
$(document).ready(function(){ 
	App.UI.search.init();
	
	@if ($nip)
		if (App.UI.search.text.container.val() != ''){
			App.UI.search.text.value('{{$nip}}', '{{$name}}')
		}
	@endif
});</script>