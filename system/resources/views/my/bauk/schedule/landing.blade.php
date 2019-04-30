@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/schedule.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		 <div id="tabs" class="w3-bar w3-black">
			<button id="tabs-default" class="w3-bar-item w3-button" onclick="tabs.hideAll().show('default')">
				{{trans('my/bauk/schedule.subtitles.landing')}}
			</button>
			<button id="tabs-exception" class="w3-bar-item w3-button" onclick="tabs.hideAll().show('exception')">
				{{trans('my/bauk/schedule.subtitles.exception')}}
			</button>
		</div> 
	</header>
	<div class="w3-row w3-container margin-top-8">
		<form id="schedule-search" name="schedule-search" action="{{route('my.bauk.schedule.landing')}}" method="post">
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
		</form>
	</div>
	<div id="tab-items" class="padding-top-8 padding-bottom-16">
		<div id="tab-items-default">@include('my.bauk.schedule.landing_default')</div>
		<div id="tab-items-exception">@include('my.bauk.schedule.landing_exception')</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
var tabs = {
	show: function(key){
		$('#tab-items-'+key).show();
		return this;
	},
	hide: function(key){
		$('#tab-items-'+key).hide();
		return this;
	},
	hideAll: function(){
		$('#tab-items').children().each(function(index, item){
			$(item).hide();
		});
		return this;
	},
	init: function(){
		var ctab = '{{request('ctab','default')}}';
		var button = $('#tabs-'+ctab).trigger('click');
	}
};

$(document).ready(function(){
	$('input[type="checkbox"]').click(function(event){ 
		event.stopPropagation(); 
	});
	
	$('.schedule-checkbox').each(function(ind, item){
		$(item).click(function(event){
			$(this).find('i')
				.toggleClass('fas')
				.toggleClass('far')
				.toggleClass('w3-text-blue');
			
			var checkbox = $(this).find('input[type="checkbox"]').trigger('click');
		});
	});
	
	$('#schedule-search').submit(function(){
		$(this).find('i').parent().css('display','');
		return true;
	});
	
	$('input.timepicker').each(function(index, item){
		$(item).timepicker({
			parseFormat: 'HH:mm:ss',
			outputFormat: 'HH:mm:ss'
		});
	});
	
	$('.ajaxSearch').each(function(ind, item){
		$(item).ajaxSearch({
			ajax:{
				type: function(){ return "post"; },
				url:  function(){ return '{{route('my.misc.search.employee')}}'; },
				data: function(){ 
					return $('#schedule-search').serialize(); 
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
				$('#schedule-search').trigger('submit');
			}
		});
	});
	
	tabs.init();
});
</script>
@endSection