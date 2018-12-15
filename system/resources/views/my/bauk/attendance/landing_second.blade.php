@if (isset($imported))
	<div id="step-2" class="w3-card w3-col s12 m12 l12">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h3>Review Data</h3>
		</header>
		
		@include('my.bauk.attendance.landing_second_small')
		@include('my.bauk.attendance.landing_second_large')
		
	</div>
@endif