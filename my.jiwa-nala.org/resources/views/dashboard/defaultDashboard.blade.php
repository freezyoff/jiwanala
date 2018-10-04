@extends('layouts.defaultLayout')

{{----------------------------------------------------}}
{{----	BEGIN: DISABLE FEATURE					
{{----------------------------------------------------}}

@if (!isset($disabledFeature))
<?php
	//disable default feature
	$disabled=[
		'html.body.tooltips',
		
		//header
		//'html.body.page.header.brand.dropdown',
		'html.body.page.header.topBar.items.search',
		'html.body.page.header.topBar.items.notification',
		'html.body.page.header.topBar.items.quickAction',
		'html.body.page.header.topBar.items.quickSideBarToggler',
		
		//subHeader
		'html.body.page.subHeader.quickAction',
		
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
{{----------------------------------------------------}}

@section('html.body.page.footer')
	@include('dashboard.default.components.footerBase')
@endSection

@section('html.body.page.aside.items')
	@foreach(config('jn.aside.menuItems') as $li)
		@include('dashboard.default.components.asides.asideItemWithDotSubItem', $li)
	@endforeach
@endSection