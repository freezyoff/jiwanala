<div class="m-stack__item m-stack__item--middle m-brand__tools">
	<div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-left m-dropdown--align-push" m-dropdown-toggle="click" aria-expanded="true">
		<a href="#" class="dropdown-toggle m-dropdown__toggle btn btn-outline-metal m-btn  m-btn--icon m-btn--pill">
			<span>
				@if (isset($dashboard_default_components_headers_brand_dropdown))
					{{ $dashboard_default_components_headers_brand_dropdown }}
				@else
					{{ getCurrentHeaderBrandDropdownCaption() }}
				@endif
			</span>
		</a>
		<div class="m-dropdown__wrapper" style="min-width:270px">
			<span class="m-dropdown__arrow m-dropdown__arrow--left m-dropdown__arrow--adjust"></span>
			<div class="m-dropdown__inner">
				<div class="m-dropdown__body">
					<div class="m-dropdown__content">
						<ul class="m-nav">
						
							@foreach( getHeaderBrandDropdownList() as $k=>$v )
							<li class="m-nav__item">
								<a href="{{ route($v['routeAction']) }}" class="m-nav__link">
									<i class="m-nav__link-icon {{$v['icon']}}"></i>
									<span class="m-nav__link-text">{{$v['caption']}}</span>
								</a>
							</li>
							@endforeach
							
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- BEGIN: Responsive Aside Left Menu Toggler -->
	<a href="javascript:;" id="m_aside_left_offcanvas_toggle" class="m-brand__icon m-brand__toggler m-brand__toggler--left m--visible-tablet-and-mobile-inline-block">
		<span></span>
	</a>
	<!-- END -->
	<!-- BEGIN: Topbar Toggler -->
	<a id="m_aside_header_topbar_mobile_toggle" href="javascript:;" class="m-brand__icon m--visible-tablet-and-mobile-inline-block">
		<i class="flaticon-more"></i>
	</a>
	<!-- BEGIN: Topbar Toggler -->
</div>