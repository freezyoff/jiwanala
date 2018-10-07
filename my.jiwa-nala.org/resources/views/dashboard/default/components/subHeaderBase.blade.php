<!-- BEGIN: Subheader -->
<div class="m-subheader ">
	<div class="d-flex align-items-center">
	
		<!--[section: html.body.page.subHeader.title]/-->
		@section('html.body.page.subHeader.title')
			@if (currentSubHeaderHasBreadcrumb())
				@include ('dashboard.default.components.subHeaders.titleWithBreadcrumb')
			@else
				@include ('dashboard.default.components.subHeaders.title')
			@endif
		@show
		<!--[endsection: html.body.page.subHeader.title]/-->
		
		<!--[section: html.body.page.quickAction]/-->
		@section('html.body.page.subHeader.quickAction')
			@if (currentSubHeaderHasQuickAction())
				@if(getCurrentSubHeaderQuickActionType() === "dateRangePicker")
					@include('dashboard.default.components.subHeaders.dateRangePickerAction')
				@else
					@include('dashboard.default.components.subHeaders.quickAction')
				@endif
			@endif
		@show
		<!--[endsection: html.body.page.subHeader.quickAction]/-->
		
	</div>
</div>
<!-- END: Subheader -->