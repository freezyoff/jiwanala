<!--
<div class="w3-container w3-row">
	<div class="w3-col s4">
		<img src="/w3images/avatar2.png" class="w3-circle w3-margin-right" style="width:46px">
	</div>
	<div class="w3-col s8 w3-bar">
		<span>
			Welcome,
			<strong>
				Mike
			</strong>
		</span>
		<br>
		<a href="#" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
		<a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
		<a href="#" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
	</div>
</div>
<hr>
<div class="w3-container">
	<h5>
		Dashboard
	</h5>
</div>
-->
<?php
	//@param $sidebar - get from parent view
	$sidebarItems = config('my.dashboardTopNav.'.$sidebar.'.sideNav');
	
	//we got array like:
	/*
	 *	[
	 *		'permission'=>''					---> permission needed to acces this link
	 *		'display'=>[ 				
	 *			'name'=>'Permission', 
	 *			'icon'=>false 
	 *		], 
	 *		'href'=>'',							---> target url on click, not read if a group
	 *		'group'=> boolean					---> flag for group sidebar item. will render with accordion
	 *		'items'=> [							---> the list of group items
	 *			[
	 *				'permission'=>''			---> permission needed to acces this link
	 *				'display'=>[ 				
	 *					'name'=>'Permission', 
	 *					'icon'=>false 
	 *				], 
	 *				'href'=>'',					---> target url on click
	 *			]
	 *		]
	 *	]
	 */
?>
<div class="w3-bar-block">
	<div class="w3-bar-item" style="display:flex !important; background-color:#d2d2d2; color:#333333">
		<div class="icon"><i class="fas fa-clock fa-fw"></i></div>
		<span id="serverTime" class="padding-left-16"></sspan>
	</div>
	<a class="w3-bar-item dashboard {{ (url()->current() == route('my.dashboard'))? 'active' : '' }}" 
		href="{{ route('my.dashboard') }}">
		<div class="icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
		<span class="">Dashboard</span>
	</a>
	@foreach($sidebarItems as $item)
		@if (!isset($item['group']) || !$item['group'])
		<?php 
			$href = route($item['href']);
			$icon = $item['display']['icon'];
			$name = $item['display']['name'];
		?>
			<!-- begin: sidebar item -->
			<a class="w3-bar-item {{ str_contains(url()->current(), $href)? 'active' : '' }}" 
				href="{{ $href }}">
				<div class="icon"><i class="{{ $icon }} fa-fw"></i></div>
				<span class="">{{ $name }}</span>
			</a>
			<!-- end: sidebar item -->
		@else
		<?php
			$accordionId = time();
			$groupItemList = $item['items'];
			$icon = $item['display']['icon'];
			$name = $item['display']['name'];
		?>
			<!-- begin: sidebar item group -->
			<a class="w3-bar-item accordion" href="#" target="{{ $accordionId }}">
				<div class="icon"><i class="{{ $icon }} fa-fw"></i> </div>
				<span class="">{{ $name }}</span>
			</a>
			@foreach($groupItemList as $lItem)
				<div id="{{ $accordionId }}" class="w3-theme-l5">
					<a class="w3-bar-item" 
						href="{{ route($lItem['href']) }}"
						style="padding: 0;display: flex !important;align-items: center; text-decoration:none;">
						<div class="icon" style="padding: 8px 16px;visibility: hidden;"><i class="fa fa-fw"></i></div>
						<span class="" style="flex-grow: 1;">{{ $lItem['display']['name'] }}</span>
					</a>
				</div>
			@endforeach
			<!-- end: sidebar item group -->
		@endif
	@endforeach
</div>
<script>
	$(document).ready(function(){
		$('.accordion').each(function(){
			$("#"+this.target).slideToggle();
		})
		 $('.accordion').on('click', function(e){
			e.preventDefault();
			$("#"+this.target).slideToggle();
		});
	});
</script>