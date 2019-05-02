<div class="w3-dropdown-click w3-hide-small" style="display:block">
	<div id="schedule-{{$i}}-{{$type}}-container" class="w3-dropdown-content w3-bar-block w3-border"></div>
</div>
<div id="schedule-{{$i}}-{{$type}}-modal" 
	class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
	onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4" style="max-width:300px; margin:auto;">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#schedule-{{$i}}-{{$type}}-modal').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas -{{$icon}}-alt fa-fw"></i>
				<span style="padding-left:12px;">
					{{$label}}
				</span>
			</h4>
		</header>
		<div id="schedule-{{$i}}-{{$type}}-modal-container" class="datepicker-inline-container"></div>
	</div>
</div>