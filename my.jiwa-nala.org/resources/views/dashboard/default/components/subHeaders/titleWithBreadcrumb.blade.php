<div class="mr-auto">
	<h3 class="m-subheader__title m-subheader__title--separator">{{getCurrentSubHeaderTitle()}}</h3>
	
	<!--[section: html.body.page.subHeader.title.breadcrumb]/-->
	@section('html.body.page.subHeader.title.breadcrumb')
		<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
			<li class="m-nav__item m-nav__item--home">
				<a href="{{route('dashboard.landing')}}" class="m-nav__link m-nav__link--icon">
				   <i class="m-nav__link-icon la la-home"></i>
				</a>
			</li>
			
			@foreach(getCurrentSubHeaderBreadcrumbList() as $ii)
				@if ($ii['type'] === "separator")
				
					<li class="m-nav__separator">-</li>
				
				@elseif ($ii['type'] === "item")
					
					<li class="m-nav__item">
						<a href="{{ route($ii['routeAction']) }}" class="m-nav__link">
							<span class="m-nav__link-text">{{ $ii['caption'] }}</span>
						</a>
					</li>
					
				@endif
			@endforeach
			
		</ul>
	@show
	<!--[endsection: html.body.page.subHeader.title.breadcrumb]/-->
	
</div>