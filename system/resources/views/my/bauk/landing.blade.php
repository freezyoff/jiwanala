@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/landing.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	@include('my.bauk.landing_holidays')
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
	$(document).ready(function(){
		
	});
</script>
@endSection