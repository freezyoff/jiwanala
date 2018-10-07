@extends('layouts.default.defaultLayout')

{{----------------------------------------------------}}
{{----	BEGIN: DISABLE FEATURE					
{{----------------------------------------------------}}

@if (!isset($disabledFeature))
<?php
	//disable default feature
	$disabled=[
		'html.body.tooltips',
		
		//header
		'html.body.page.header.topBar.items.search',
		'html.body.page.header.topBar.items.notification',
		'html.body.page.header.topBar.items.quickAction',
		'html.body.page.header.topBar.items.quickSideBarToggler',
		
		//subHeader
		'html.body.quickSideBar',
		
	];
?>
@endif

@foreach($disabled as $key)

	@section($key)		
	@endSection
	
@endforeach
	
{{----------------------------------------------------}}
{{----	BEGIN: FEATURE					
{{----	@param (optional) $dashboard_default_components_headers_brand_dropdown 
{{----	@param (optional) $html_body_page_aside_visible 
{{----	@param (optional) $html_body_page_aside_items
{{----	@param (optional) $html_body_page_subHeader_title
{{----	@param (optional) $html_body_page_subHeader_title_breadcrumb
{{----------------------------------------------------}}

@section('html.body.page.aside')
	@if (isset($html_body_page_aside_visible))
		@if ($html_body_page_aside_visible)
			@parent
		@endif
	@else
		@if (currentAsideHasList())
			@parent
		@endif
	@endif

@endSection

@section('html.body.page.aside.items')
	@if( currentAsideHasList() )
		@foreach(getCurrentAsideList() as $li)
			@include('dashboard.default.components.asides.asideItemWithDotSubItem', $li)
		@endforeach
	@endif
@endSection

@section('html.body.page.subHeader')
	@include('dashboard.default.components.subHeaderBase')
@endSection