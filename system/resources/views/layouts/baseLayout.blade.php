<!DOCTYPE html>
<html 
@section('html.attributes')
app-version="{{config('app.version')}}" 
lang="{{config('app.locale')}}" 
lang-fallback="{{config('app.fallback_locale')}}"
timezone="{{config('app.timezone')}}"
client-timezone="{{session()->get('timezone')}}"
time="{{\Carbon\Carbon::now()}}"
client-time="{{\Carbon\Carbon::now(session()->get('timezone'))}}"
@show
>
	<!-- begin::Head -->
	<head>        
		<!--[section: html.head.title]/-->
		@section('html.head.title')
			<title>{{config('app.name')}}</title>
		@show
		<!--[endsection: html.head.title]/-->
		
		<!--[section: html.head.metas]/-->
		@section('html.head.metas')
			<meta charset="UTF-8">
			<meta name="theme-color" content="#f1f1f1" />
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="csrf-token" content="{{ csrf_token() }}">
		@show
		<!--[endsection: html.head.metas]/-->
		
		<!--[section: html.head.scripts]/-->
		@section('html.head.scripts')
			<script src="https://momentjs.com/downloads/moment.js"></script>
			<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
			<script>
				//"Poppins:300,400,500,600,700,800,900",
				WebFont.load({google: {families:["Roboto:300,400,500,600,700,800,900"]}, active: function() { sessionStorage.fonts = true; }});
			</script>
			<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
			<script src="{{url('/js/app.js?v='.csrf_token())}}"></script>
		@show
		<!--[endsection: html.head.scripts]/-->
		
		<!--[section: html.head.styles]/-->
		@section('html.head.styles')
			<link rel="stylesheet" href="{{ url('css/app.css?v='.csrf_token()) }}"  type="text/css" />
		@show
		<!--[endsection: html.head.styles]/-->
	
	</head>    
	<!-- end::Head -->        
	
	<!-- begin::Body -->    
	<body
		@section('body.attributes')
		@show
		@section('html.body.attributes')
		@show
	>
		
		<!--[section: html.body.content]/-->
		@section('html.body.content')
		@show
		<!--[endsection: html.body.content]/-->
		
		<!--[section: html.body.scripts]/-->
		@section('html.body.scripts')
		@show
		<!--[endsection: html.body.scripts]/-->
		
	</body>
	<!-- end::Body -->
	
</html>