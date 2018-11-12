@if($type === 1)
	
{{----------------------------------------------------}}
{{----	LABEL
{{----	@param caption
{{----	@param icon 
{{----------------------------------------------------}}
	<!-- BEGIN: Aside Menu Label	-->
	<li class="m-menu__section m-menu__section--first">
		<h4 class="m-menu__section-text">{{$caption}}</h4>
		<i class="m-menu__section-icon flaticon-more-v2"></i>
	</li>
	<!-- END: Aside Menu Label	-->

@elseif($type === 2 )
	
{{----------------------------------------------------}}
{{----	ITEM
{{----	@param $caption
{{----	@param $icon
{{----	@param $routeAction
{{----------------------------------------------------}}
	<!-- BEGIN: Aside Menu Item	-->
	<li class="m-menu__item " aria-haspopup="true"  m-menu-link-redirect="1">
		<a  href="{{route($routeAction)}}" class="m-menu__link ">
			<i class="m-menu__link-icon {{$icon}}"></i>
			<span class="m-menu__link-text">{{$caption}}</span>
		</a>
	</li>
	<!-- END: Aside Menu Label	-->
	
@else
	
{{----------------------------------------------------}}
{{----	ITEM & SUB-ITEM
{{----	@param $label => ['caption','icon']
{{----	@param $items[] => array['caption','routeAction']
{{----------------------------------------------------}}
	<!-- BEGIN: Aside Menu Item	with Sub-Menu	-->
	<li class="m-menu__item  m-menu__item--submenu" aria-haspopup="true"  m-menu-submenu-toggle="hover">
		<a  href="javascript:;" class="m-menu__link m-menu__toggle">
			<i class="m-menu__link-icon {{$label['icon']}}"></i>
			<span class="m-menu__link-text">{{$label['caption']}}</span>
			<i class="m-menu__ver-arrow la la-angle-right"></i>
		</a>
		
	@if ( is_array($items) )
		<div class="m-menu__submenu ">
			<span class="m-menu__arrow"></span>
			<ul class="m-menu__subnav">
				@foreach($items as $ii)
					<li class="m-menu__item " aria-haspopup="true" >
						<a  href="{{$ii['routeAction']}}" class="m-menu__link ">
							<i class="m-menu__link-bullet m-menu__link-bullet--dot">
								<span></span>
							</i>
							<span class="m-menu__link-text">{{$ii['caption']}}</span>
						</a>
					</li>
				@endforeach
					
			</ul>
		</div>
	@endif
	
	</li>
	<!-- END: Aside Menu Item	with Sub-Menu	-->
	
@endif