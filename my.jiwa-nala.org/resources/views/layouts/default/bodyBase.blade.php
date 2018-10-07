<!-- begin:: Page -->
<div class="m-grid m-grid--hor m-grid--root m-page">
	
	<!--[section: html.body.page.header]/-->
	@section('html.body.page.header')
		@include('layouts.default.components.headerBase')
	@show
	<!--[endsection: html.body.page.header]/-->

	<!-- begin:: Page Body -->
	<div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
	
			<!--[section: html.body.page.aside]/-->
			@section('html.body.page.aside')
				@include('layouts.default.components.asideBase')
			@show
			<!--[endsection: html.body.page.aside]/-->
			
			<div class="m-grid__item m-grid__item--fluid m-wrapper">

				<!--[section: html.body.page.subHeader]/-->
				@section('html.body.page.subHeader')
					@include('layouts.default.components.subHeaderBase')
				@show
				<!--[endsection: html.body.page.subHeader]/-->
				
				<div class="m-content">
					<!--[section: html.body.page.content]/-->
					@section('html.body.page.content')
					@show
					<!--[endsection: html.body.page.content]/-->
				</div>
				
			</div>
	</div>
	<!-- end:: Page Body -->

	<!--[section: html.body.page.footer]/-->
	@section('html.body.page.footer')
		@include('layouts.default.components.footerBase')
	@show
	<!--[endsection: html.body.page.footer]/-->
</div>
<!-- end:: Page -->

<!--[section: html.body.quickSideBar]/-->
@section('html.body.quickSideBar')
	@include('layouts.default.components.quickSideBarBase')
@show
<!--[endsection: html.body.quickSideBar]/-->

<!--[section: html.body.scrollTop]/-->
@section('html.body.scrollTop')
	@include('layouts.default.components.scrollTopBase')
@show
<!--[endsection: html.body.scrollTop]/-->

<!--[section: html.body.tooltips]/-->
@section('html.body.tooltips')
	@include('layouts.default.components.tooltipsBase')
@show
<!--[endsection: html.body.tooltips]/-->