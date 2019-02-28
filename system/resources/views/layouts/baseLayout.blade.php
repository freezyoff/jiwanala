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
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<meta name="csrf-token" content="{{ csrf_token() }}">
		@show
		<!--[endsection: html.head.metas]/-->
		
		<!--[section: html.head.scripts]/-->
		@section('html.head.scripts')
			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js?"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.23/moment-timezone-with-data.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
			<script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
			<script>
				//"Poppins:300,400,500,600,700,800,900",
				WebFont.load({google: {families:["Roboto:300,400,500,600,700,800,900"]}, active: function() { sessionStorage.fonts = true; }});
			</script>
			<script src="{{url('js/app.js?'.csrf_token())}}"></script>
		@show
		<!--[endsection: html.head.scripts]/-->
		
		<!--[section: html.head.styles]/-->
		@section('html.head.styles')
			<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
			<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
			<link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-black.css">
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