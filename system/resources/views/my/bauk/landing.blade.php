@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/landing.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	@include('my.bauk.landing_attendanceDocumentationProgress')
	@include('my.bauk.landing_employees')
	@include('my.bauk.landing_holidays')
</div>
<div class="w3-row">
	{{-- @include('my.bauk.landing_fingerConsent')--}}
</div>
@endSection

@section('html.body.scripts')
@parent
@endSection