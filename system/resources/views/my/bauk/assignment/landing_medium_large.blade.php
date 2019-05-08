<div class="w3-container margin-top-16 margin-bottom-16">
	<div class="w3-col m6 l6" style="padding-right:4px">
		<div class="employee-list w3-responsive table-assigned">
			<h5>Telah Bertugas</h5>
			@include('my.bauk.assignment.landing_table',['mode'=>'release', 'employees'=>$assigned])
		</div>
	</div>
	<div class="w3-col m6 l6" style="padding-left:4px">
		<div class="employee-list w3-responsive table-unassigned">
			<h5>Belum Bertugas</h5>
			@include('my.bauk.assignment.landing_table',['mode'=>'assign', 'employees'=>$unassigned])
		</div>
	</div>
</div>