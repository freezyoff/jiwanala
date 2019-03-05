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
	<a class="w3-bar-item dashboard {{ (url()->current() == route('my.dashboard.landing'))? 'active' : '' }}" 
		href="{{ route('my.'.$sidebar.'.landing') }}">
		<div class="icon"><i class="fas fa-tachometer-alt fa-fw"></i></div>
		<span class="">{{strtoupper($sidebar)}} Dashboard</span>
	</a>
	@foreach($sidebarItems as $item)
		@if ( (!isset($item['group']) || !$item['group']) && \Auth::user()->hasPermission($item['permission']) )
			<!-- begin: sidebar item -->
			<a class="w3-bar-item {{ str_contains( url()->current(), route($item['href']))? 'selected' : '' }}" 
				href="{{ route($item['href']) }}">
				<div class="icon"><i class="{{ $item['display']['icon'] }} fa-fw"></i></div>
				<span class="">
					{{ $item['display']['name'] }}
					@if (isset($item['display']['tag']))
						<span class="w3-tag margin-left-8 {{$item['display']['tag']['color']}}" 
							style="font-size:.8em">
							{{ $item['display']['tag']['label'] }}
						</span>
					@endif
					@if (isset($item['display']['badge']))
						<span class="w3-tag margin-left-8 {{$item['display']['badge']['color']}}" 
							style="font-size:.8em">
							{{ $item['display']['badge']['label'] }}
						</span>
					@endif
				</span>
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
			<a class="w3-bar-item accordion
				
				@foreach($groupItemList as $item)
					{{ str_contains(url()->current(), route($item['href']))? 'active' : '' }}
				@endforeach
				
				"
				href="#" 
				accordion="#{{ $accordionId }}">
				<div class="icon"><i class="{{ $icon }} fa-fw"></i> </div>
				<span class="">{{ $name }}</span>
			</a>
			<div id="{{ $accordionId }}" class="accordion-item">
			@foreach($groupItemList as $lItem)
				<a class="w3-bar-item {{ str_contains(url()->current(), route($lItem['href']))? 'selected' : '' }}" 
					href="{{ route($lItem['href']) }}"
					style="padding: 0;display: flex !important;align-items: center; text-decoration:none;">
					<div class="icon">
						<i class="fas fa-caret-right fa-fw"></i>
					</div>
					<span style="flex-grow: 1;">
						{{ $lItem['display']['name'] }}
						@if (isset($lItem['display']['tag']))
							<span class="w3-tag margin-left-8 {{$lItem['display']['tag']['color']}}" 
								style="font-size:.8em">
								{{ $lItem['display']['tag']['label'] }}
							</span>
						@endif
						@if (isset($lItem['display']['badge']))
							<span class="w3-tag margin-left-8 {{$lItem['display']['badge']['color']}}" 
								style="font-size:.8em">
								{{ $lItem['display']['badge']['label'] }}
							</span>
						@endif
					</span>
				</a>
			@endforeach
			</div>
			<!-- end: sidebar item group -->
		@endif
	@endforeach
</div>
<script>
	/*
	$(document).ready(function(){
		$('.accordion').on('click', function(event){
			event.preventDefault();
			$(this.accordion).slideToggle();
			$(this).toggleClass('collapse');
		});
		 
		 $('.accordion').each(function(index, item){
			if ( !$(item).hasClass('active') ){
				$(item).trigger('click');
			}
		})
	});
	*/
</script>