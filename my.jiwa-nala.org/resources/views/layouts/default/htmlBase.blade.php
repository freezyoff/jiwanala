<?php
	$appVersion = config('app.theme');
?>

<!DOCTYPE html>

<!-- Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
	Author: KeenThemesWebsite: http://www.keenthemes.com/Contact: 
	support@keenthemes.com
	Follow: www.twitter.com/keenthemes
	Dribbble: www.dribbble.com/keenthemes
	Like: www.facebook.com/keenthemes
	Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemesRenew 
	Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
	License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
	
<html lang="{{ config('app.locale') }}" lang-fallback="{{ config('app.fallback_locale') }}" app-version="{{$appVersion}}">
	<!-- begin::Head -->    
	<head>        
		<meta charset="utf-8" />
		
		<!--[section: html.head.title]/-->
		@yield('html.head.title')
		<!--[endsection: html.head.title]/-->
		
		<!--[section: html.head.metas]/-->
		@yield('html.head.metas')
		<!--[endsection: html.head.metas]/-->
		
		<!--[section: html.head.scripts]/-->
		@yield('html.head.scripts')
		<!--[endsection: html.head.scripts]/-->
		
		<!--[section: html.head.styles]/-->
		@yield('html.head.styles')
		<!--[endsection: html.head.styles]/-->
	
	</head>    
	<!-- end::Head -->        
		
	<!-- begin::Body -->    
	<body  class="m-content--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-light m-aside--offcanvas-default"  >
		
		<!--[section: html.body.page]/-->
		@yield('html.body.page')
		<!--[endsection: html.body.page]/-->
		
		<!--[section: html.body.scripts]/-->
		@yield('html.body.scripts')
		<!--[endsection: html.body.scripts]/-->
		
	</body>
	<!-- end::Body -->
</html>