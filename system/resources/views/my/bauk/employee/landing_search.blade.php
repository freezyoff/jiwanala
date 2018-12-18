<form name="searchkey" class="w3-form padding-none margin-none" method="POST" action="{{route('my.bauk.employee')}}">
	@csrf
	<input name="keyactive" type="hidden" value="{{isset($keyactive)? $keyactive: '1'}}" />
	<div class="w3-col s12 m7 l8">
		<div class="input-group">
			<label><i class="far fa-keyboard fa-fw w3-large"></i></label>
			<input name="keywords" 
				type="text" 
				value="{{$keywords?: ''}}"
				placeholder="{{trans('my/bauk/employee/landing.hints.key_words')}}" 
				class="input w3-input"/>
		</div>
		<label>&nbsp;</label>
	</div>
	<div class="w3-col s12 m5 l4 padding-left-8 padding-none-small w3-hide-large">
		<div class="input-group">
			<input name="keyactive_small" 
				type="text" 
				value="{{$keyactive_small?: trans('my/bauk/employee/landing.hints.key_active_items.active')}}"
				placeholder="{{trans('my/bauk/employee/landing.hints.key_active')}}" 
				class="input w3-input"
				readonly="readonly"/>
			<label><i class="fas fa-chevron-down w3-large"></i></label>
		</div>
		<div id="keyactive-modal" class="w3-modal w3-display-container" onclick="$(this).hide()">
			<div class="w3-modal-content w3-animate-top w3-card-4">
				<header class="w3-container w3-theme">
					<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
						onclick="$('#keyactive-modal').hide()" 
						style="font-size:20px !important">
						×
					</span>
					<h4 class="padding-top-8 padding-bottom-8">
						<i class="fas fa-search"></i>
						<span style="padding-left:12px;">{{trans('my/bauk/employee/landing.hints.keyactive_modal')}}</span>
					</h4>
				</header>
				<div class="w3-bar-block" style="width:100%">
					<ul class="w3-ul w3-hoverable" style="font-size:1.2em">
						<li style="cursor:pointer">
							<a class="w3-text-theme w3-mobile" 
								data-value="1">
								<i class="fas fa-lightbulb "></i>
								<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.active')}}</span>
							</a>
						</li>
						<li style="cursor:pointer">
							<a class="w3-text-theme w3-mobile" 
								data-value="0">
								<i class="far fa-lightbulb"></i>
								<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.inactive')}}</span>
							</a>
						</li>
						<li style="cursor:pointer;">
							<a class="w3-text-theme w3-mobile" 
								data-value="-1">
								<i class="fas fa-asterisk"></i>
								<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.all')}}</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<label>&nbsp;</label>
	</div>
	<div class="w3-col s12 m5 l4 padding-left-8 w3-hide-small w3-hide-medium">
		<div class="input-group">
			<input name="keyactive_large" 
				type="text" 
				value="{{$keyactive_large?: trans('my/bauk/employee/landing.hints.key_active_items.active')}}"
				placeholder="{{trans('my/bauk/employee/landing.hints.key_active')}}" 
				class="input w3-input"
				readonly="readonly"/>
			<label><i class="fas fa-chevron-down w3-large"></i></label>
		</div>
		<div id="keyactive-dropdown" class="w3-dropdown-content w3-bar-block w3-card">
			<ul class="w3-ul w3-hoverable">
				<li style="cursor:pointer">
					<a class="w3-text-theme w3-mobile" 
						data-value="1">
						<i class="fas fa-lightbulb"></i>
						<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.active')}}</span>
					</a>
				</li>
				<li style="cursor:pointer">
					<a class="w3-text-theme w3-mobile" 
						data-value="0">
						<i class="far fa-lightbulb"></i>
						<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.inactive')}}</span>
					</a>
				</li>
				<li style="cursor:pointer;">
					<a class="w3-text-theme w3-mobile" 
						data-value="-1">
						<i class="fas fa-asterisk"></i>
						<span style="padding-left:12px">{{trans('my/bauk/employee/landing.hints.key_active_items.all')}}</span>
					</a>
				</li>
			</ul>
		</div>
		<label>&nbsp;</label>
	</div>
</form>