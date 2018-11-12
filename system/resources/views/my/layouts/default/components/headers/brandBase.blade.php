<!-- BEGIN: Brand -->
<div class="m-stack__item m-brand  m-brand--skin-light ">
	<div class="m-stack m-stack--ver m-stack--general m-stack--fluid">
		<div class="m-stack__item m-stack__item--middle m-brand__logo">
				
			<!--[section: html.body.page.header.brand.img]/-->
			@section('html.body.page.header.brand.img')
				<a href="{{ url('') }}" class="m-brand__logo-wrapper">
					<img alt="" src="{{ asset('vendors/metronic/demo/demo11/media/img/logo/logo.png') }}"/>
				</a>
			@show
			<!--[endsection: html.body.page.header.brand.img]/-->
			
		</div>
		
		<!--[section: html.body.page.header.brand.dropdown]/-->
		@section('html.body.page.header.brand.dropdown')
			@include('layouts.default.components.headers.brand.dropdown')
		@show
		<!--[endsection: html.body.page.header.brand.dropdown]/-->

	</div>
</div>
<!-- END: Brand -->