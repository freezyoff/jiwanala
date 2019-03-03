<div id="delete-modal-{{$empl->id}}" class="w3-modal w3-display-container w3-hide-large" onclick="$(this).hide()">
	<div class="w3-modal-content w3-animate-top w3-card-4">
		<header class="w3-container w3-theme">
			<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
				onclick="$('#delete-modal-{{$empl->id}}').hide()" 
				style="font-size:20px !important">
				×
			</span>
			<h4 class="padding-top-8 padding-bottom-8">
				<i class="fas fa-lightbulb fa-fw"></i>
				<span style="padding-left:12px;">{{trans('my/system/user.hints.modals.delete')}}</span>
			</h4>
		</header>
		<div id="delete-modal-{{$empl->id}}-container" class="datepicker-inline-container">
			<table>
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
	</div>
</div>