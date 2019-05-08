<div id="delete-modal-{{$empl->id}}" class="w3-modal w3-display-container" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
				onclick="$('#delete-modal-{{$empl->id}}').hide()">
				×
			</h4>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-user-slash"></i>
				<span style="padding-left:12px;">{{trans('my/system/user.modals.delete')}}</span>
			</h4>
		</header>
		<div id="delete-modal-{{$empl->id}}-container" class="datepicker-inline-container">
			<table class="w3-table w3-table-all">
				<tbody>
					<tr>
						<td>NIP</td>
						<td></td>
						<td>{{ $empl->nip }}</td>
					</tr>
					<tr>
						<td>Nama</td>
						<td></td>
						<td>{{ $empl->getFullName() }}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<footer class="padding-top-bottom-8">
			<div align="right">
				<button
					class="w3-button w3-blue w3-hover-blue margin-right-8"
					onclick="$('#delete-modal-{{$empl->id}}').hide()">
					<i class="fas fa-times"></i>
					<span class="padding-left-8">{{trans('my/system/user.hints.cancel')}}</span>
				</button>
				<button
					class="w3-button w3-red w3-hover-red margin-right-8"
					onclick="document.location='{{route('my.system.user.delete',['nip'=>$empl->asUser->id])}}'">
					<i class="fas fa-user-minus"></i>
					<span class="padding-left-8">{{trans('my/system/user.hints.delete')}}</span>
				</button>
			</div>
		</footer>
	</div>
</div>