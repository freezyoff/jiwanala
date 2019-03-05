<div id="link-modal-{{$empl->id}}" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#link-modal-{{$empl->id}}').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-user-shield"></i>
				<span style="padding-left:12px;">{{trans('my/system/user.hints.create')}}</span>
			</h4>
		</header>
		<div id="link-modal-{{$empl->id}}-container" class="datepicker-inline-container">
			<div class="w3-bar-block" style="width:100%">
				<ul class="w3-ul w3-hoverable">
					@forelse($empl->asPerson()->first()->emails()->get() as $email)
					<li style="cursor:pointer;" 
						onclick="document.location='{{route('my.system.user.create',['nip'=>$empl->nip,'email'=>$email->email])}}'">
						<a class="w3-text-theme w3-mobile" 
							select-role="item" 
							select-value="{{$email->email}}">
							{{ $email->email }}
						</a>
					</li>
					@empty
						<li style="cursor:pointer;">
							<a class="w3-text-theme w3-mobile" 
								select-role="item" 
								select-value="-1">
								Belum mendaftarkan email
							</a>
						</li>
					@endforelse
				</ul>
			</div>
		</div>
	</div>
</div>