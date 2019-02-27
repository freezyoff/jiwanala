<div id="fingerConsent" class="w3-col s12 m6 l6 w3-light-grey">
	<div class="w3-card w3-light-grey">
		<header class="w3-container padding-top-8">
			<h4>Finger Kedatangan & Kepulangan</h4>
		</header>
		<div class="w3-container padding-top-16 padding-bottom-16">
			<table class="w3-table w3-bordered">
				<tbody>
					<tr>
						<td>Datang Terlambat</td>
						<td>:</td>
						<td id="fingerConsent_lateArrival" style="text-align:right"><i class="button-icon-loader"></i></td>
					</tr>
					<tr>
						<td>Pulang Awal</td>
						<td>:</td>
						<td id="fingerConsent_earlyDeparture" style="text-align:right"><i class="button-icon-loader"></i></td>
					</tr>
					<tr>
						<td>Cuti</td>
						<td>:</td>
						<td id="" style="text-align:right"><i class="button-icon-loader"></i></td>
					</tr>
					<tr>
						<td>Izin</td>
						<td>:</td>
						<td id="" style="text-align:right"><i class="button-icon-loader"></i></td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
var fingerConsent = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.fingerConsent')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#fingerConsent_lateArrival').html(response.lateArrival + " kali");
		}
	});
};

$(document).ready(function(){
	fingerConsent();
	setInterval(fingerConsent, 1000*60*10);
});
</script>