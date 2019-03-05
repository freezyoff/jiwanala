<div id="attendanceProgress" class="w3-col s12 m12 l4 w3-light-grey">
	<div class="padding-top-16 padding-bottom-16 margin-right-16 margin-none-small margin-none-medium">
		<div class="w3-col s12 m3 l12 margin-bottom-8 margin-none-medium" style="min-width:135px">
			<div style="display:flex; flex-direction:column;align-items:center;">
				<div id="progressbar-radial" 
					class="progressbar radial xlarge" 
					style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset; ">
					<span id="progressbar-radial-label"><i class="button-icon-loader"></i></span>
					<div class="slice">
						<div class="bar"></div>
						<div class="fill"></div>
					</div>
				</div>
				<span id="progressbar-title"
					class="padding-top-8" 
					style="font-size:.7em; text-align:center">
					Progres rekaman karyawan fulltime
				</span>
			</div>
		</div>
		<div class="w3-col s12 m9 l12 padding-left-8 padding-none-small padding-none-large">
			<table class="w3-table">
				<tbody>
					<tr>
						<td>Hari Kerja</td>
						<td>:</td>
						<td style="text-align:right">
						@if ($progress['scheduleDaysCount']>0)
							{{$progress['scheduleDaysCount']}} hari
						@endif
						</td>
					</tr>
					<tr>
						<td>Kehadiran</td>
						<td>:</td>
						<td style="text-align:right">
						@if ($progress['attends']>0)
							{{$progress['attends']}} hari
						@endif
						</td>
					</tr>
					<tr>
						<td>Tanpa Keterangan</td>
						<td>:</td>
						<td style="text-align:right">
						@if ($progress['absents']>0)
							{{$progress['absents']}} hari
						@endif
						</td>
					</tr>
					<tr>
						<td>Terlambat / Pulang Awal</td>
						<td>:</td>
						<td style="text-align:right">
						@if ($progress['lateArrivalOrEarlyDeparture']>0)
							{{$progress['lateArrivalOrEarlyDeparture']}} hari
						@endif
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>