let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.setPublicPath('./../my.jiwa-nala.org/js')
	//.extract(['jquery', '@chenfengyuan/datepicker'],'./../my.jiwa-nala.org/js/vendor.js')
	
	/**
	 *	JS
	 **/
	//combine vendor extract with other vendor
	.combine([
		'resources/assets/js/vendors/datepicker.js',
		'resources/assets/js/vendors/cowboy/jquery-throttle-debounce.js',
		'resources/assets/js/app.js'
	], './../my.jiwa-nala.org/js/app.js')
	
	/**
	 *	CSS
	 **/
	.less('resources/assets/css/app.less', './../css/app.css')
	
	/**
	 *	image & font
	 **/
	.copy('resources/assets/media', './../my.jiwa-nala.org/media');

//deploy
mix.copy('./../my.jiwa-nala.org', './../service.jiwa-nala.org', true);