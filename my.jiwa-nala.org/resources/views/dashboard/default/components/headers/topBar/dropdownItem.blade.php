<!--[section: html.body.page.header.topBar.items.item]/-->
<!--													
--	 $align (left, center, right)	: dropdown alignment. value: 
--	 $size (small, medium, large)	: size of the dropdown. value: 
--	 $icon (string)					: name of the icon
--	 $badge (string)				: value of the badge. Badge will visible if $badge have a value.
--	 $header (HTML)					: html tag of the header.
--	 $content (HTML)				: html tag of the content.
-->

<li class="m-nav__item m-topbar__notifications m-dropdown m-dropdown--{{$size}} m-dropdown--arrow m-dropdown--align-{{$align}} m-dropdown--mobile-full-width" 
	m-dropdown-toggle="click" 
	m-dropdown-persistent="1">
	
	<a href="#" class="m-nav__link m-dropdown__toggle" id="m_topbar_notification_icon">
		<span class="m-nav__link-icon">
			
			@section('html.body.page.header.topBar.items.item.icon')
				<span class="m-nav__link-icon-wrapper">
					<i class="{{$icon}}"></i>
				</span>
				<span>Akunting</span>
			@show
			
			@section('html.body.page.header.topBar.items.item.badge')
				@if (isset($badge))
					<span class="m-nav__link-badge m-badge m-badge--success">{{$badge}}</span>
				@endif
			@show
			
		</span>
	</a>
	<div class="m-dropdown__wrapper">
		<span class="m-dropdown__arrow m-dropdown__arrow--{{$align}}"></span>
		<div class="m-dropdown__inner">
			
			@section('html.body.page.header.topBar.items.item.header')
				<div class="m-dropdown__header m--align-center">
						@if (isset($header))
							{{$header}}
						@endif
				</div>
			@show
			
			@section('html.body.page.header.topBar.items.item.body')
			<div class="m-dropdown__body">
				<div class="m-dropdown__content">
					@if (isset($header))
						{{$content}}
					@endif
				</div>
			</div>
			@endSection
			
		</div>
	</div>
	
</li>
<!--[endsection: html.body.page.header.topBar.items.item]/-->