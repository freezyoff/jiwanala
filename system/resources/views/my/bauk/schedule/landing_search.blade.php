<form id="search-form" name="search-form" action="{{route('my.bauk.schedule.landing')}}" method="post">
	<div class="w3-row w3-container margin-top-8">
		@csrf
		<div class="w3-row">
			<div class="w3-col s12 m6 l6">
				<div class="input-group">
					<label><i class="fas fa-search fa-fw"></i></label>
					<input id="search-keywords" 
						name="keywords"
						class="w3-input ajaxSearch" 
						value=""
						placeholder="{{trans('my/bauk/schedule.hints.searchKeywords')}}" 
						type="text" />
					<input name="active" value="1" type="hidden" />
					<input id="search-nip" name="employee_nip" value="" type="hidden" />
				</div>
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){
	$('#search-form').submit(function(){
		$(this).find('i').parent().css('display','');
		return true;
	});
	
	$('.ajaxSearch').each(function(ind, item){
		$(item).ajaxSearch({
			ajax:{
				type: function(){ return "post"; },
				url:  function(){ return '{{route('my.misc.search.employee')}}'; },
				data: function(){ 
					return $('#search-form').serialize(); 
				},
			},
			modal: {
				icon:'{{trans('my/bauk/schedule.modal.searchEmployee.icon')}}',
				title:'{{trans('my/bauk/schedule.modal.searchEmployee.title')}}'
			},
			onFocus: function(){},
			onListItemClicked: function(json){
				$('#search-keywords').val(json.nip);
				$('#search-nip').val(json.nip);
				$('#search-form').trigger('submit');
			}
		});
	});
});
</script>