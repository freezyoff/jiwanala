<div class="w3-row w3-container">
	<div class="w3-col s12 m12 l8 schedule">
		@include('my.bauk.schedule.landing_employee')
		<div class="margin-top-bottom-16">
			@if (old('employee_nip', isset($employee)? $employee->nip : false))
			<button type="button" class="w3-button w3-indigo w3-hover-indigo"
				onclick="$(this).next().show()">
				<i class="fas fa-calendar-alt margin-right-8"></i>
				Tambah Tanggal
			</button>
			@endif
			@include('my.bauk.schedule.landing_exception_form_add')
		</div>
		@include('my.bauk.schedule.landing_exception_table')
	</div>
</div>