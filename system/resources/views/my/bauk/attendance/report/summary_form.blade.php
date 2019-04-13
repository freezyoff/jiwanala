<form id="summary-form" 
	name="summary-form" 
	action="{{route('my.bauk.attendance.report.summary')}}"
	method="post">
	@csrf
	<div class="w3-col s12 m12 l6">
		<div class="input-group">
			<label><i class="fas fa-calendar fa-fw"></i></label>
			<input id="summary-year" 
				name="summary_year" 
				value="{{isset($summary_year)? $summary_year : \App\Libraries\Core\WorkYear::getCurrent()->id}}"
				type="text" 
				class="w3-input" 
				role="select"
				select-dropdown="#summary-year-dropdown"
				select-modal="#summary-year-modal"
				select-modal-container="#summary-year-modal-container" />
		</div>
		@include('my.bauk.attendance.report.summary_year_dropdown')
		@include('my.bauk.attendance.report.summary_year_modal')
		<label>Tahun Akademik</label>
	</div>
</form>