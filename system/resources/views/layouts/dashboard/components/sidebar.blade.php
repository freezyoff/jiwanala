@if ( $item && $item->group instanceof \App\Libraries\Navigation\NullMenuAttributes )
	<!-- begin: sidebar item -->
	<a class="w3-bar-item {{ $item->selected? 'selected' : '' }}" 
		href="{!! $item->href !!}">
		<div class="icon"><i class="{{ $item->display->icon }} fa-fw"></i></div>
		<span class="">
			{{ $item->display->name }}
			@if ($item->display->tag)
				<span class="w3-tag margin-left-8 {{$item->display->tag->color}}" 
					style="font-size:.8em">
					{{ $item->display->tag->label }}
				</span>
			@endif
			@if (isset($item->display->badge))
				<span class="w3-tag margin-left-8 {{$item->display->badge->color}}" 
					style="font-size:.8em">
					{{ $item->display->badge->label }}
				</span>
			@endif
		</span>
	</a>
	<!-- end: sidebar item -->
@elseif($item && $item->group)
<?php $accordionId = time(); ?>
	<!-- begin: sidebar item group -->
	<a class="w3-bar-item accordion
		
		@foreach($item->items as $item)
			{{ $item->selected? 'active' : '' }}
		@endforeach
		
		"
		href="#" 
		accordion="#{{ $accordionId }}">
		<div class="icon"><i class="{{ $item->display->icon }} fa-fw"></i> </div>
		<span class="">{{ $item->display->name }}</span>
	</a>
	<div id="{{ $accordionId }}" class="accordion-item">
	@foreach($item->items() as $sub)
		<a class="w3-bar-item {{ $sub->selected? 'selected' : '' }}" 
			href="{{ $sub->href }}"
			style="padding: 0;display: flex !important;align-items: center; text-decoration:none;">
			<div class="icon">
				<i class="fas fa-caret-right fa-fw"></i>
			</div>
			<span style="flex-grow: 1;">
				{{ $sub->display->name }}
				@if ($sub->display->tag)
					<span class="w3-tag margin-left-8 {{$sub->display->tag->color}}" 
						style="font-size:.8em">
						{{ $sub->display->tag->label }}
					</span>
				@endif
				@if ($sub->display->badge)
					<span class="w3-tag margin-left-8 {{$sub->display->badge->color}}" 
						style="font-size:.8em">
						{{ $sub->display->badge->label }}
					</span>
				@endif
			</span>
		</a>
	@endforeach
	</div>
	<!-- end: sidebar item group -->
@endif