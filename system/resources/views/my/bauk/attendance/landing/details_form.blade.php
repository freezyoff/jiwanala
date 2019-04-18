<div class="w3-row">
	<div class="w3-col s12 m6 l4">
		<div class="input-group">
			<label><i class="fas fa-calendar fa-fw"></i></label>
			<input id="month" 
				name="month" 
				value="{{isset($month)? $month : now()->format('n')}}"
				type="text" 
				class="w3-input" 
				role="select"
				select-dropdown="#month-dropdown"
				select-modal="#month-modal"
				select-modal-container="#month-modal-container" />
		</div>
		@include('my.bauk.attendance.landing.details_form_month_dropdown')
		@include('my.bauk.attendance.landing.details_form_month_modal')
		<label>&nbsp;</label>
	</div>
	<div class="w3-col s12 m6 l4 padding-left-8 padding-none-small">
		<div class="input-group">
			<label><i class="fas fa-calendar fa-fw"></i></label>
			<input id="year" name="year" type="text" class="w3-input" 
				value="{{isset($year)? $year : now()->format('Y')}}" 
				role="select"
				select-dropdown="#year-dropdown"
				select-modal="#year-modal"
				select-modal-container="#year-modal-container" />
		</div>
		@include('my.bauk.attendance.landing.details_form_year_dropdown')
		@include('my.bauk.attendance.landing.details_form_year_modal')
		<label>&nbsp;</label>
	</div>
</div>