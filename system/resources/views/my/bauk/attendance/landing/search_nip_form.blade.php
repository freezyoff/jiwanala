<form id="searchNIP" action="{{route('my.bauk.attendance.search.employee')}}" method="POST">
	@csrf
	<div class="w3-row">
		<div class="w3-col s12 m6 l4">
			<div class="input-group" style="justify-content:start">
				<label><i class="fas fa-user-circle fa-fw"></i></label>
				<input id="searchNIP-nip" 
					name="nip" 
					value="{{$nip}}"
					class="w3-input input" 
					type="text" 
					placeholder="NIP" 
					autocomplete="off" />
			</div>
			<div class="w3-dropdown-click w3-hide-small" style="display:block">
				<div id="searchNIP-dropdown" 
					class="w3-card w3-dropdown-content w3-bar-block w3-border" 
					style="width:100%; max-height:400px; overflow:hidden scroll;">
					<ul class="w3-ul w3-hoverable" style="display:table; list-style:none; width:100%"></ul>
				</div>
			</div>
			<label>&nbsp;</label>
		</div>
		<div class="w3-col s12 m6 l5 padding-left-8 padding-none-small">
			<div class="input-group" style="justify-content:start">
				<label><i class="fas fa-font fa-fw"></i></label>
				<label name="name" for="searchNIP-nip" style="width:100%"></label>
			</div>
		</div>
	</div>
</form>