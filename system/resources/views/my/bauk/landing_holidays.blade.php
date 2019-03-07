<div id="nextHolidays" class="w3-col s12 m6 l6 margin-top-8">
	<div class="w3-card">
		<header class="w3-container w3-red padding-top-8">
			<h4>Hari Libur Selanjutnya</h4>
		</header>
		<table class="w3-table w3-striped w3-bordered">
			<thead>
				<tr class="w3-red">
					<th>Tanggal</th>
					<th>Hari Libur</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="2"><i class="button-icon-loader"></i></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<div class="w3-hide-large w3-hide-medium">&nbsp;</div>
<script>
var nextHolidays = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.nextHolidays')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: 'html',
		beforeSend: function() {},
		success: function(response){
			$('#nextHolidays').find('tbody').empty().html(response);
		}
	});
};

$(document).ready(function(){
	nextHolidays();
	//setInterval(nextHolidays, 1000*10);
});
</script>