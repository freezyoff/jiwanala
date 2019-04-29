@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/schedule.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		 <div id="tabs" class="w3-bar w3-black">
			<button class="w3-bar-item w3-button" onclick="tabs.hideAll().show('default')">
				{{trans('my/bauk/schedule.subtitles.landing')}}
			</button>
			<button class="w3-bar-item w3-button" onclick="tabs.hideAll().show('special')">
				{{trans('my/bauk/schedule.subtitles.special')}}
			</button>
		</div> 
	</header>
	<div id="tab-items" class="padding-top-8 padding-bottom-16">
		<div id="default">@include('my.bauk.schedule.landing_default')</div>
		<div id="special">SPECIAL</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
var tabs = {
	show: function(key){
		$('#'+key).show();
		return this;
	},
	hide: function(key){
		$('#'+key).hide();
		return this;
	},
	hideAll: function(){
		$('#tab-items').children().each(function(){
			$(this).hide();
		});
		return this;
	},
	init: function(){
		var toShow = '{{request('ctabs','default')}}';
		if (toShow) $('#'+toShow).trigger('click');
		else 		$('#tabs').children().first().trigger('click');
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