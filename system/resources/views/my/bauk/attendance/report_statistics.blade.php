<div class="w3-col s12 m4 l4">
	<div style="display:flex; flex-direction:column;align-items:center;margin-top:8px;">
		<div id="progressbar-radial" 
			class="progressbar radial xlarge" 
			style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset;">
			<span id="progressbar-radial-label"><i class="button-icon-loader"></i></span>
			<div class="slice">
				<div class="bar"></div>
				<div class="fill"></div>
			</div>
		</div>
		<span id="progressbar-title" class="padding-top-8" style="font-size:.7em; text-align:center"></span>
	</div>
</div>
<div class="w3-col s12 m8 l8">
	<table class="w3-table w3-bordered">
		<tbody>
			<tr>
				<td>Cuti / Izin</td>
				<td>:</td>
				<td style="text-align:right" id="empoyee-consents"><i class="button-icon-loader"></i></td>
			</tr>
			<tr>
				<td>Terlambat / Pulang Awal</td>
				<td>:</td>
				<td style="text-align:right" id="empoyee-lateArrivalOrEarlyDeparture"><i class="button-icon-loader"></i></td>
			</tr>
			<tr>
				<td colspan="3">Tanpa dokumen Cuti / Izin</td>
			</tr>
			<tr>
				<td><span class="padding-left-16">Terlambat / Pulang Awal</span></td>
				<td>:</td>
				<td style="text-align:right" id="employee-noLateOrEarlyDocs"><i class="button-icon-loader"></i></td>
			</tr>
			<tr>
				<td><span class="padding-left-16">Cuti / Izin</span></td>
				<td>:</td>
				<td style="text-align:right" id="employee-noConsentDocs"><i class="button-icon-loader"></i></td>
			</tr>
		</tbody>
	</table>
</div>