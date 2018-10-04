<!-- begin::Footer -->
<footer class="m-grid__item		m-footer ">
	<div class="m-container m-container--fluid m-container--full-height m-page__container">
		<div class="m-stack m-stack--flex-tablet-and-mobile m-stack--ver m-stack--desktop">
			<div class="m-stack__item m-stack__item--left m-stack__item--middle m-stack__item--last">
				<span class="m-footer__copyright">				
					
					<!--[section: html.body.page.footer.copyright]/-->
					@section('html.body.page.footer.copyright')
						<span>2017 &copy; Metronic theme by </span>
						<a href="https://keenthemes.com" class="m-link">Keenthemes</a>
					@show
					<!--[endsection: html.body.page.footer.copyright]/-->
					
				</span>
			</div>
			<div class="m-stack__item m-stack__item--right m-stack__item--middle m-stack__item--first">
				<ul class="m-footer__nav m-nav m-nav--inline m--pull-right">
					
					<!--[section: html.body.page.footer.navigation]/-->
					@section('html.body.page.footer.navigation')
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<span class="m-nav__link-text">About</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="#"  class="m-nav__link">
							<span class="m-nav__link-text">Privacy</span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<span class="m-nav__link-text"> T&nC </span>
						</a>
					</li>
					<li class="m-nav__item">
						<a href="#" class="m-nav__link">
							<span class="m-nav__link-text">Purchase</span>
						</a>
					</li>
					<li class="m-nav__item m-nav__item--last">
						<a href="#" class="m-nav__link" data-toggle="m-tooltip" title="Support Center" data-placement="left">
							<i class="m-nav__link-icon flaticon-info m--icon-font-size-lg3"></i>
						</a>
					</li>
					@show
					<!--[endsection: html.body.page.footer.navigation]/-->
					
				</ul>
			</div>
		</div>
	</div>
</footer>
<!-- end::Footer -->