<!-- @parm $sidebar -->
<!-- @parm $showSidebar -->

@if ($showSidebar)
<div class="w3-bar-block">
	<div class="w3-bar-item" style="display:flex !important; background-color:#d2d2d2; color:#333333">
		<div class="icon"><i class="fas fa-clock fa-fw"></i></div>
		<span id="serverTime" class="padding-left-16"></span>
	</div>
	<a class="w3-bar-item dashboard {{ (url()->current() == route('my.dashboard.landing'))? 'active' : '' }}" 
		href="{{ route('my.'.$sidebar.'.landing') }}">
		<div class="icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
		<span class="">
			@if(strtolower($sidebar) != 'dashboard')
			{{strtoupper($sidebar)}} 
			@endif
			Dashboard
		</span>
	</a>
	
	@foreach(\App\Libraries\Foundation\Navigation\Factory::makeSidebar($sidebar) as $item)
		@include('layouts.dashboard.components.sidebar',['item'=>$item])
	@endforeach
	
</div>
@endif