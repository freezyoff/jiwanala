<div class="w3-row w3-container">
	<div class="w3-col s12 m12 l8 schedule padding-right-16">
		<form id="schedule-exception-submit" 
			name="schedule-exception-submit" 
			action="{{route('my.bauk.schedule.store.exception')}}" 
			method="post">
			@csrf
			@include('my.bauk.schedule.landing_exception_form')
			<div class="w3-col s12 m12 l12" align="right">
					<button id="btnSubmit" 
						class="w3-button w3-mobile w3-blue w3-hover-blue margin-top-16"
						type="submit"
						onclick="$(this).find('i').removeClass('fa-cloud-upload-alt').addClass('button-icon-loader')">
						<i class="fas fa-cloud-upload-alt fa-fw margin-right-8"></i>
						{{trans('my/bauk/schedule.hints.save')}}
					</button>
			</div>
		</form>
		<div class="w3-responsive">
			<table class="w3-table w3-table-all">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Jam Kerja</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>