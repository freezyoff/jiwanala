<div class="w3-container margin-top-16">
	<div class="w3-bar w3-theme-l2">
		<button class="w3-bar-item w3-button w3-hover-blue" target="#small-assigned">Telah Bertugas</button>
		<button class="w3-bar-item w3-button w3-blue w3-hover-blue" target="#small-unassigned">Belum Bertugas</button>
	</div>
</div>
<div class="w3-container padding-bottom-16">
	<div id="small-assigned" class="employee-list w3-responsive table-assigned">
		@include('my.bauk.assignment.landing_table',['mode'=>'release', 'employees'=>$assigned])
	</div>
	<div id="small-unassigned" class="employee-list w3-responsive table-unassigned">
		@include('my.bauk.assignment.landing_table',['mode'=>'assign', 'employees'=>$unassigned])
	</div>
</div>
<script>
$(document).ready(function(){
	$('.w3-bar-item').click(function(){
		$('.w3-bar-item').each(function(index,item){
			$(item).removeClass('w3-blue');
			$($(this).attr('target')).css('display','none');
		});
		$(this).toggleClass('w3-blue');
		$($(this).attr('target')).css('display','block');
	});
	
	$('button[target="#small-assigned"]').trigger('click');
});
</script>