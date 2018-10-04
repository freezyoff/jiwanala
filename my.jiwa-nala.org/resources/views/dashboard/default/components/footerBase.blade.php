<!-- begin::Footer -->
<footer class="m-grid__item		m-footer ">
	<div class="m-container m-container--fluid m-container--full-height m-page__container">
		<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
			<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
				<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
					
					<!--[section: html.body.page.footer.navigation]/-->
					@section('html.body.page.footer.navigation')
						@include('dashboard.default.components.footer.navigation')
					@show
					<!--[endsection: html.body.page.footer.navigation]/-->
					
				</ul>
			</div>
			<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--last">
				<span class="m-footer__copyright">
					
					<!--[section: html.body.page.footer.copyright]/-->
					@section('html.body.page.footer.copyright')
						@include('dashboard.default.components.footer.copy')
					@show
					<!--[endsection: html.body.page.footer.copyright]/-->
					
				</span>
			</div>
		</div>
	</div>
</footer>
<!-- end::Footer -->