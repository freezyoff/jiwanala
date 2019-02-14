<div id="nextHolidays" class="w3-col s12 m6 l6">
	<h4>Hari Libur Selanjutnya</h4>
	<table class="w3-table w3-table-all">
		<thead>
			<tr>
				<th>Tanggal</th>
				<th>Hari Libur</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="2"><i class="button-icon-loader"></i></td>
			<tr>
		</tbody>
	</table>
</div>

@section('html.body.scripts')
@parent
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
	 setInterval(nextHolidays, 1000*10);
});
</script>
@endSection