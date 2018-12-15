<form id="large" class="w3-hide-small">
	<div class="w3-container padding-bottom-24">
		<table class="w3-table-all w3-hoverable w3-hide-small">
			<thead>
				<tr class="w3-theme-l1">
					<th width="16%">NIP</th>
					<th width="16%">Tanggal</th>
					<th width="16%">Finger Masuk</th>
					<th width="16%">Finger Keluar 1</th>
					<th width="16%">Finger Keluar 2</th>
					<th width="16%">Finger Keluar 3</th>
				</tr>
			</thead>
			<tbody>
				@foreach($imported as $row=>$value)
				<tr>
					<td>	
						<input name="nip[{{$row}}][large]" 
							data-value="input[name='nip[{{$row}}]']"
							type="text" 
							class="w3-input 
								@if ($errors->has('{{$row}}.nip'))
									error
								@endif
							"
							value="{{$value['nip']}}" />
						<input name="nip[{{$row}}]" type="hidden" />
					</td>
					<td>
						<input name="tanggal[{{$row}}][large]" 
							data-toggle="datepicker"
							data-value="input[name='tanggal[{{$row}}]']"
							type="text" 
							class="w3-input"
							value="{{$value['tanggal']}}" />
						<input name="tanggal[{{$row}}]" type="hidden" value="{{$value['tanggal']}}" />
					</td>
					<td>
						<input name="finger[{{$row}}][masuk]" type="hidden" value="{{$value['finger_masuk']}}" />
						<input name="finger[{{$row}}][masuk][large]" 
							data-toggle="timepicker"
							data-value="input[name='finger[{{$row}}][masuk]']"
							data-container="#finger-{{$row}}-masuk-large-dropdown-content"
							data-dropdown="#finger-{{$row}}-masuk-large-dropdown"
							type="text" 
							class="w3-input"
							value="{{$value['finger_masuk']}}" />
						<div id="finger-{{$row}}-masuk-large-dropdown" class="w3-dropdown-click w3-hide-small" style="display:inherit;">
							<div id="finger-{{$row}}-masuk-large-dropdown-content" class="w3-card w3-dropdown-content w3-bar-block w3-border" style="min-width:100px"></div>
						</div>
					</td>
					<td>
						<input name="finger[{{$row}}][keluar][1][large]" 
							data-toggle="timepicker"
							data-value="input[name='finger[{{$row}}][keluar][1]']"
							data-container="#finger-{{$row}}-keluar-1-large-dropdown-content"
							data-dropdown="#finger-{{$row}}-keluar-1-large-dropdown"
							type="text" 
							class="w3-input"
							value="{{$value['finger_keluar_1']}}" />
						<input name="finger[{{$row}}][keluar][1]" type="hidden" value="{{$value['finger_keluar_1']}}" />
						<div id="finger-{{$row}}-keluar-1-large-dropdown" class="w3-dropdown-click w3-hide-small" style="display:inherit;">
							<div id="finger-{{$row}}-keluar-1-large-dropdown-content" class="w3-card w3-dropdown-content w3-bar-block w3-border" style="min-width:100px"></div>
						</div>
					</td>
					<td>
						<input name="finger[{{$row}}][keluar][2][large]" 
							data-toggle="timepicker"
							data-value="input[name='finger[{{$row}}][keluar][2]']"
							data-container="#finger-{{$row}}-keluar-2-large-dropdown-content"
							data-dropdown="#finger-{{$row}}-keluar-2-large-dropdown"
							type="text" 
							class="w3-input"
							value="{{$value['finger_keluar_2']}}" />
						<input name="finger[{{$row}}][keluar][2]" type="hidden" value="{{$value['finger_keluar_2']}}" />
						<div id="finger-{{$row}}-keluar-2-large-dropdown" class="w3-dropdown-click w3-hide-small" style="display:inherit;">
							<div id="finger-{{$row}}-keluar-2-large-dropdown-content" class="w3-card w3-dropdown-content w3-bar-block w3-border" style="min-width:100px"></div>
						</div>
					</td>
					<td>
						<input name="finger[{{$row}}][keluar][3][large]" 
							data-toggle="timepicker"
							data-value="input[name='finger[{{$row}}][keluar][3]']"
							data-container="#finger-{{$row}}-keluar-3-large-dropdown-content"
							data-dropdown="#finger-{{$row}}-keluar-3-large-dropdown"
							type="text" 
							class="w3-input"
							value="{{$value['finger_keluar_3']}}" />
						<input name="finger[{{$row}}][keluar][3]" type="hidden" value="{{$value['finger_keluar_3']}}" />
						<div id="finger-{{$row}}-keluar-3-large-dropdown" class="w3-dropdown-click w3-hide-small" style="display:inherit;">
							<div id="finger-{{$row}}-keluar-3-large-dropdown-content" class="w3-card w3-dropdown-content w3-bar-block w3-border" style="min-width:100px"></div>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
	{{print_r($errors,true)}}
</form>