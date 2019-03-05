<!-- begin: Top Bar Small Screen style -->
<div class="w3-hide-medium w3-hide-large w3-bar" style="display:flex;">
	@if($sidebar)
		<button class="jn-sidebar-toggle w3-bar-item w3-button w3-hover-none w3-text-light-grey w3-hover-text-white">
			<i class="fa fa-bars"></i>
		</button>
	@endif
	<a class="brand"
		href="{{url('')}}">
		<img src="{{url('media/img/brand.png')}}">					
		<div class="brand-text">
			<div class="title">JIWANALA</div>
			<div class="subtitle">Learn . Explore . Lead</div>
		</div>
	</a>
	<div class="top-nav">
		<button class="w3-bar-item w3-button w3-hover-none w3-text-light-grey w3-hover-text-white" 
			onclick="$('#jn-modal').show()">
			<i class="fas fa-ellipsis-v"></i>
		</button>
	</div>
	<div id="jn-modal" class="w3-modal" onclick="$(this).hide()">
		<div class="w3-modal-content w3-animate-top w3-card-4">
			<header class="w3-container w3-theme">
				<span onclick="document.getElementById('jn-modal').style.display='none'" 
					class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
					style="font-size:20px !important;">
					&times;
				</span>
				<h4 class="padding-top-8 padding-bottom-8">
					<i class="fa fa-bars"></i>
					<span style="padding-left:12px;">Choose:</span>
				</h4>
			</header>
			<ul class="w3-ul">
				@foreach(config('my.dashboardTopNav') as $key=>$item)
					@if( !isset($item['permission_context']) || Auth::user()->hasPermissionContext($key) )
						<li class="w3-hover-light-grey" style="cursor:pointer;">
							<a class="w3-text-theme w3-mobile
								@if(isset($item['display']['class']))
									{{$item['display']['class']}}
								@endif
								"
								style="text-decoration:none;"
								href="{{$item['href']? route($item['href']) : ''}}">
								<i class="{{$item['display']['icon']}}"></i>
								<span style="padding-left:12px">{{ucfirst($item['display']['name'])}}</span>
							</a>
						</li>
					@endif
				@endforeach
				<li class="w3-hover-light-grey">
					<a class="w3-text-theme w3-mobile" style="text-decoration:none; text-decoration:none;"
						href="{{route('service.auth.logout')}}">
						<i class="fas fa-power-off"></i>
						<span style="padding-left:12px">Log Out</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<!-- end: Top Bar Small Screen style -->
<!-- begin: Top Bar Medium & Large Screen style -->
<div class="w3-hide-small w3-bar" style="display:flex; padding-left:16px; padding-right:16px;">
	@if($sidebar)
		<button class="jn-sidebar-toggle w3-button w3-hover-none w3-hover-text-light-grey w3-large w3-hide-large"
			style="padding-left:0;">
			<i class="fa fa-bars"></i>
		</button>
	@endif
	<a class="brand"
		href="{{url('')}}">
		<img src="{{url('media/img/brand.png')}}">
		<div class="brand-text">
			<div class="title">JIWANALA</div>
			<div class="subtitle">Learn . Explore . Lead</div>
		</div>
	</a>
	<div class="top-nav">
		@foreach(config('my.dashboardTopNav') as $key=>$item)
			@if( !isset($item['permission_context']) || Auth::user()->hasPermissionContext($item['permission_context']) )
				<button class="w3-bar-item w3-button w3-hover-none 
					@if(isset($item['display']['class']))
						{{$item['display']['class']}}
					@endif
					"
					onclick="{{$item['href']? 'document.location=\''.route($item['href']).'\'' : ''}}">
					<i class="{{$item['display']['icon']}}"></i>
					<span>{{ucfirst($item['display']['name'])}}</span>
				</button>
			@endif
		@endforeach
		<button class="w3-bar-item w3-button w3-hover-none" 
			onclick="document.location='{{route('service.auth.logout')}}'">
			<i class="fas fa-power-off"></i>
			<span>Log out</span>
		</button>
	</div>
</div>
<!-- end: Top Bar Medium && Large Screen style -->