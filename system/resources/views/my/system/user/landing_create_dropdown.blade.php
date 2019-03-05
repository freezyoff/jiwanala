<div id="link-dropdown-{{$empl->id}}" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium"
	style="right:32px;">
	<ul class="w3-ul w3-hoverable">
		<li style="text-align:left" class="w3-light-grey">
			<a class="w3-text-theme w3-mobile">
				<i class="fas fa-envelope"></i>
				<span class="padding-left-8">Email:</span>
			</a>
		</li>
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