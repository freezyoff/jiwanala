<form id="exception-search-form" 
	name="exception-search-form"
	action="{{route('my.bauk.schedule.landing')}}" 
	method="post">
	@csrf
	<input name="ctab" value="exception" type="hidden" />
	@include('my.bauk.schedule.landing_employee')
	<div class="w3-row">
		<div class="w3-col s12 m6 l6">
			<div class="input-group padding-top-8">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<?php 
					$monthID = str_replace('-','',\Illuminate\Support\Str::uuid());
					$dropdown = [
						'id'		=> $monthID,
						'name'		=> 'exception_month',
						'value'		=> $exception_periode->format('m'),
						'dropdown'	=> ['layouts.dashboard.components.select_date_items', ['month'=>true]]
					];
				?>
				@include('layouts.dashboard.components.select', $dropdown)
			</div>
		</div>
		<div class="w3-col s12 m6 l6">
			<div class="input-group margin-left-8 margin-none-small padding-top-8">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<?php 
					$yearID = str_replace('-','',\Illuminate\Support\Str::uuid());
					$dropdown = [
						'id'		=> $yearID,
						'name'		=> 'exception_year',	
						'value'		=> $exception_periode->format('Y'),
						'dropdown'	=> ['layouts.dashboard.components.select_date_items', ['year'=>true]]
					];
				?>
				@include('layouts.dashboard.components.select', $dropdown)
			</div>
		</div>
	</div>
</form>
<script>
$(document).ready(function(){
	$('input#{{$monthID}}, input#{{$yearID}}').on('select.pick', function(){
		$('form#exception-search-form').trigger('submit');
	});
});
</script>