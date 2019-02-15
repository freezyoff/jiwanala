<div id="employeesCount" class="w3-col s12 m6 l6">
	<div class="w3-card">
		<header class="w3-container w3-indigo padding-top-8 padding-bottom-8">
			<h4>KARYAWAN<h4>
		</header>
		<table class="w3-table w3-striped w3-bordered">
			<thead>
				<tr class="w3-indigo">
					<th>Full / Part Time</th>
					<th style="text-align:center;">Jumlah (org)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>Karyawan Aktif</td>
					<td style="text-align:center;" id="employeesCount-active">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
				<tr>
					<td>Karyawan Full Time</td>
					<td style="text-align:center;" id="employeesCount-fulltime">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
				<tr>
					<td>Karyawan Full Time Kontrak tahun 1</td>
					<td style="text-align:center;" id="employeesCount-contract-1">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
				<tr>
					<td>Karyawan Full Time Kontrak tahun 2</td>
					<td style="text-align:center;" id="employeesCount-contract-2">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
			</tbody>
		</table>		
	</div>
</div>
<div class="w3-hide-large w3-hide-medium">&nbsp;</div>
<script>
var employeesCount = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.employeesCount')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#employeesCount-active').html(response.count);
			$('#employeesCount-fulltime').html(response.fulltime);
			$('#employeesCount-parttime').html(response.parttime);
			$('#employeesCount-contract-1').html(response.contract1);
			$('#employeesCount-contract-2').html(response.contract2);
		}
	});
};

$(document).ready(function(){
	employeesCount();
	setInterval(employeesCount, 1000*60*10);
});
</script>