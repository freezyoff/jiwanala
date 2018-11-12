<!-- BEGIN: Header -->
<header id="m_header" class="m-grid__item m-header"  m-minimize-offset="200" m-minimize-mobile-offset="200" >	
	<div class="m-container m-container--fluid m-container--full-height">		
		<div class="m-stack m-stack--ver m-stack--desktop">					

			<!--[section: html.body.page.header.brand]/-->
			@section('html.body.page.header.brand')
				@include('layouts.default.components.headers.brandBase')
			@show
			<!--[endsection: html.body.page.header.brand]/-->
			
			<div class="m-stack__item m-stack__item--fluid m-header-head" id="m_header_nav">
		
				<!--[section: html.body.page.header.topBar]/-->
				@section('html.body.page.header.topBar')
					@include('layouts.default.components.headers.topBarBase')
				@show
				<!--[endsection: html.body.page.header.topBar]/-->
				
			</div>
		</div>	
	</div>
</header>
<!-- END: Header -->