<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
	
		<!--[section: html.body.page.subHeader.title]/-->
		@section('html.body.page.subHeader.title')
			@include('layouts.default.components.subHeaders.title')
		@show
		<!--[endsection: html.body.page.subHeader.quickAction]/-->
		
		<!--[section: html.body.page.subHeader]/-->
		@section('html.body.page.subHeader.quickAction')
			@include('layouts.default.components.subHeaders.quickAction')
		@show
		<!--[endsection: html.body.page.subHeader.quickAction]/-->
		
	</div>
</div>
<!-- END: Subheader -->