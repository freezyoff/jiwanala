<div id="attendanceProgress" class="w3-col s12 m12 l12 margin-bottom-16">
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>Progres Rekaman Data Kehadiran<h4>
		</header>
		<div class="w3-container padding-top-8 padding-bottom-8">
			<div class="w3-light-grey w3-round" style="text-align:center">
				<span id="progressbar-label" style="position:absolute;"></span>
				<div id="progressbar" class="w3-container w3-green w3-center w3-round">
					&nbsp;
				</div>
			</div> 
		</div>
	</div>
</div>
<div class="w3-hide-large w3-hide-medium">&nbsp;</div>
<script>
var attendanceProgress = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.attendanceProgress')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#progressbar-label').html(response+'%');
			$('#progressbar').animate({
				width:response+'%'
			});
		}
	});
};

$(document).ready(function(){
	attendanceProgress();
	setInterval(employeesCount, 1000*60*10);
});
</script>