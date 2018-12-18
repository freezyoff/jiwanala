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
		href="{{ route('my.'.$sidebar.'.landing') }}">
		<div class="icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
		<span class="">{{strtoupper($sidebar)}} Dashboard</span>
	</a>
	@foreach($sidebarItems as $item)
		@if ( (!isset($item['group']) || !$item['group']) && \Auth::user()->hasPermission($item['permission']) )
		<?php 
			$href = route($item['href']);
			$icon = $item['display']['icon'];
			$name = $item['display']['name'];
		?>
			<!-- begin: sidebar item -->
			<a class="w3-bar-item {{ str_contains( url()->current(), $href)? 'active' : '' }}" 
				href="{{ $href }}">
				<div class="icon"><i class="{{ $icon }} fa-fw"></i></div>
				<span class="">{{ $name }}</span>
			</a>
			<!-- end: sidebar item -->
		@elseif (isset($item['group']))
		<?php
			$accordionId = time();
			$groupItemList = $item['items'];
			$icon = $item['display']['icon'];
			$name = $item['display']['name'];
			$links = [];
		?>
			<!-- begin: sidebar item group -->
			<a class="w3-bar-item 
				accordion
				@foreach($groupItemList as $item)
					{{ str_contains(route($item['href']), url()->current())? 'active' : '' }}
				@endforeach
				"
				href="#" 
				target="{{ $accordionId }}">
				<div class="icon"><i class="{{ $icon }} fa-fw"></i> </div>
				<span class="">{{ $name }}</span>
			</a>
			<div id="{{ $accordionId }}" class="accordion-item">
			@foreach($groupItemList as $lItem)
					<a class="w3-bar-item {{ url()->current() == route($lItem['href'])? 'active' : '' }}" 
						href="{{ route($lItem['href']) }}"
						style="padding: 0;display: flex !important;align-items: center; text-decoration:none;">
						<div class="icon">
							<i class="fas fa-caret-right fa-fw"></i>
						</div>
						<span style="flex-grow: 1;">{{ $lItem['display']['name'] }}</span>
					</a>
			@endforeach
			</div>
			<!-- end: sidebar item group -->
		@endif
	@endforeach
</div>
<script>
	$(document).ready(function(){
		$('.accordion').on('click', function(event){
			event.preventDefault();
			$("#"+this.target).slideToggle();
		});
		 
		 $('.accordion').each(function(index, item){
			if ( !$(item).hasClass('active') ){
				$(item).trigger('click');
			}
		})
	});
</script>