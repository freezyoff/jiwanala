@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/schedule.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8">
		 <div id="tabs" class="w3-bar w3-black" style="white-space:nowrap">
			<button id="tabs-default" 
				class="w3-bar-item w3-button" 
				onclick="tabs.hideAll().show('default', this)"
				style="white-space:nowrap">
				{{trans('my/bauk/schedule.subtitles.landing')}}
			</button>
			<button id="tabs-exception" 
				class="w3-bar-item w3-button" 
				onclick="tabs.hideAll().show('exception', this)"
				style="white-space:nowrap">
				{{trans('my/bauk/schedule.subtitles.exception')}}
			</button>
		</div> 
	</header>
	@include('my.bauk.schedule.landing_search')
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
	show: function(key, button){
		$('#tab-items-'+key).show();
		$(button).addClass('w3-light-grey');
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
		
		$('#tabs').children().each(function(index, item){
			$(item).removeClass('w3-light-grey');
		});
		return this;
	},
	init: function(){
		var ctab = '{{old('ctab',$ctab? $ctab : 'default')}}';
		var button = $('#tabs-'+ctab).trigger('click');
	}
};

$(document).ready(function(){
	tabs.init();
});
</script>
@endSection