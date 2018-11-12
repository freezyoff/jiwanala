<!-- BEGIN: Topbar -->
<div id="m_header_topbar" class="m-topbar  m-stack m-stack--ver m-stack--general">
	<div class="m-stack__item m-topbar__nav-wrapper">
		<ul class="m-topbar__nav m-nav m-nav--inline">
		
			<!--[section: html.body.page.header.topBar.items]/-->
			@section('html.body.page.header.topBar.items')
			
				<!--[section: html.body.page.header.topBar.items.search]/-->
				@section('html.body.page.header.topBar.items.search')
					@include('layouts.default.components.headers.topBar.search')
				@show
				<!--[endsection: html.body.page.header.topBar.items.search]/-->
				
				<!--[section: html.body.page.header.topBar.items.notification]/-->
				@section('html.body.page.header.topBar.items.notification')
					@include('layouts.default.components.headers.topBar.notification')
				@show
				<!--[endsection: html.body.page.header.topBar.items.notification]/-->
				
				<!--[section: html.body.page.header.topBar.items.quickAction]/-->
				@section('html.body.page.header.topBar.items.quickAction')
					@include('layouts.default.components.headers.topBar.quickAction')
				@show
				<!--[endsection: html.body.page.header.topBar.items.quickAction]/-->
				
				<!--[section: html.body.page.header.topBar.items.userProfile]/-->
				@section('html.body.page.header.topBar.items.userProfile')
					@include('layouts.default.components.headers.topBar.userProfile')
				@show
				<!--[endsection: html.body.page.header.topBar.items.userProfile]/-->
				
				<!--[section: html.body.page.header.topBar.items.quickSideBarToggler]/-->
				@section('html.body.page.header.topBar.items.quickSideBarToggler')
				<li id="m_quick_sidebar_toggle" class="m-nav__item m-topbar__quick-sidebar">
					<a href="#" class="m-nav__link m-dropdown__toggle">
						<span class="m-nav__link-icon">
							<i class="flaticon-grid-menu"></i>
						</span>
					</a>
				</li>
				@show
				<!--[endsection: html.body.page.header.topBar.items.quickSideBarToggler]/-->
				
			@show
			<!--[endsection: html.body.page.header.topBar.items]/-->
			
		</ul>
	</div>
</div>
<!-- END: Topbar -->