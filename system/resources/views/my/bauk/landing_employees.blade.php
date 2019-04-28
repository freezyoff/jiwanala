<div id="statistics" class="w3-col s12 m6 l6 margin-top-8 margin-top-none-medium margin-top-none-large">
	<div class="w3-card margin-left-8 margin-left-none-small">
		<header class="w3-container padding-top-8 w3-blue">
			<h4>Statistik Karyawan Fulltime</h4>
		</header>
		<table class="w3-table w3-bordered">
			<thead>
				<tr class="w3-blue">
					<th>Keterangan / Status</th>
					<td></td>
					<th>Jumlah (org)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Aktif</td>
					<td>:</td>
					<td id="employee-active" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime</td>
					<td>:</td>
					<td id="employee-fulltime" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime Kontrak thn ke 2</td>
					<td>:</td>
					<td id="employee-fulltime-contract-2" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
				<tr>
					<td>Fulltime Kontrak thn ke 1</td>
					<td>:</td>
					<td id="employee-fulltime-contract-1" style="text-align:right"><i class="button-icon-loader"></i></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>	
<script>
var employeesCount = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.employeesCount')}}',
		data: { 
			'_token': '{{csrf_token()}}',
			'year': $('#attendanceProgress-year').val(),
			'month': $('#attendanceProgress-month').val(),
		},
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#employee-active').html(response.count+' org');
			$('#employee-fulltime').html(response.fulltime+' org');
			$('#employee-fulltime-contract-1').html(response.contract1+' org');
			$('#employee-fulltime-contract-2').html(response.contract2+' org');
		}
	});
};

$(document).ready(function(){
	employeesCount();
});
</script>