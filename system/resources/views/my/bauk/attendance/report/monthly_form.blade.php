<form id="monthly-form" 
	name="monthly-form" 
	action="{{route('my.bauk.attendance.report.attendance')}}"
	method="post">
	@csrf
	<div class="w3-col s12 m6 l6">
		<div class="input-group">
			<label><i class="fas fa-calendar fa-fw"></i></label>
			<input id="attendanceProgress-month" 
				name="month" 
				value="{{isset($month)? $month : now()->format('m')}}"
				type="text" 
				class="w3-input" 
				role="select"
				select-dropdown="#month-dropdown"
				select-modal="#month-modal"
				select-modal-container="#month-modal-container" />
		</div>
		@include('my.bauk.attendance.report.monthly_month_dropdown')
		@include('my.bauk.attendance.report.monthly_month_modal')
		<label>&nbsp;</label>
	</div>
	<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-calendar fa-fw"></i></label>
			<input id="attendanceProgress-year" 
				name="year" 
				type="text" 
				class="w3-input" 
				value="{{isset($year)? $year : now()->format('Y')}}" 
				role="select"
				select-dropdown="#year-dropdown"
				select-modal="#year-modal"
				select-modal-container="#year-modal-container" />
		</div>
		@include('my.bauk.attendance.report.monthly_year_dropdown')
		@include('my.bauk.attendance.report.monthly_year_modal')
		<label>&nbsp;</label>
	</div>
</form>