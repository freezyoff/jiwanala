@extends('dashboard.default.abstractDashboard')

@section('html.body.page.header.brand.dropdown')
	@include('dashboard.default.components.headers.brand.dropdown')
@endSection

@section('html.body.page.footer')
	@include('dashboard.default.components.footerBase')
@endSection

@section('html.body.scripts.page')
	@parent
@endSection