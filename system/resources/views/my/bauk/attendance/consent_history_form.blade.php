<form id="submitForm" method="post" action="{{ $post_action }}" enctype="multipart/form-data">
	@csrf
	<input name="employee_id" value="{{$employee->id}}" type="hidden" />
	<input name="employee_nip" value="{{$employee->nip}}" type="hidden" />
	<input name="date" value="{{$date->format('Y-m-d')}}" type="hidden" />
	<input name="end" value="{{ old('end', $consent? \Carbon\Carbon::createFromFormat('Y-m-d', $consent->end)->format('d-m-Y') : $date->format('d-m-Y'))  }}" type="hidden" />
	<input name="consent_record_id" value="{{$consent? $consent->id : ''}}" type="hidden" />
	<input name="back_action" value="{{$back_action}}" type="hidden" />
	<div class="w3-container">
		<div class="w3-col s12 m6 l6">
			<div class="input-group">
				<label><i class="fas fa-user-circle fa-fw"></i></label>
				<label style="width:100%">{{$employee->nip}}</label>
			</div>
			<label>&nbsp;</label>
		</div>
		<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
			<div class="input-group">
				<label><i class="fas fa-font fa-fw"></i></label>
				<label style="width:100%">{{$employee->getFullName()}}</label>
			</div>
			<label>&nbsp;</label>
		</div>
	</div>
	<div class="w3-container">
		<div class="w3-col s12 m6 l6">
			<div class="input-group">
				<label><i class="fas fa-calendar fa-fw"></i></label>
				<label style="width:100%">
					{{trans('calendar.days.long.'.($date->dayOfWeek))}}, &nbsp;
					{{$date->day}}&nbsp;
					{{trans('calendar.months.long.'.($date->month-1))}}&nbsp;
					{{$date->year}}
				</label>
			</div>
			<label>&nbsp;</label>
		</div>
		<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
			<div class="input-group">
				<label><i class="fas fa-sort-numeric-down fa-fw"></i></label>
				<input id="endlarge" 
					name="endlarge" 
					type="text" 
					class="w3-input w3-hide-small w3-hide-medium" 
					value="{{ old('end', $consent? \Carbon\Carbon::createFromFormat('Y-m-d', $consent->end)->format('d-m-Y') : $date->format('d-m-Y')) }}" 
					placeholder="Sampai tanggal"
					autocomplete="off"
					readonly="readonly"
					role="datepicker-dropdown"
					datepicker-value="input[name='end']"
					datepicker-link="input[name='endsmall']" />
				<input id="endsmall" 
					name="endsmall" 
					type="text" 
					class="w3-input w3-hide-large" 
					value="{{ old('end', $consent? \Carbon\Carbon::createFromFormat('Y-m-d', $consent->end)->format('d-m-Y') : $date->format('d-m-Y')) }}" 
					placeholder="Sampai tanggal"
					autocomplete="off"
					readonly="readonly"
					role="datepicker-modal"
					datepicker-modal="#endsmall-modal"
					datepicker-container="#endsmall-modal-container" 
					datepicker-value="input[name='end']" 
					datepicker-link="input[name='endlarge']" />
			</div>
			
			@if ($errors->has('end'))
			<label class="padding-left-8 w3-text-red" style="font-size:.8em">
				<span>{{ $errors->first('end') }}<span>
			</label>
			@else
			<label>&nbsp;</label>
			@endif
			
			<div id="endsmall-modal" 
				class="w3-modal w3-display-container datepicker-modal w3-hide-large" 
				onclick="$(this).hide()">
				<div class="w3-modal-content w3-animate-top w3-card-4">
					<header class="w3-container w3-theme">
						<h4 class="w3-button w3-display-topright w3-hover-none w3-hover-text-light-grey"
							onclick="$('#endsmall-modal').hide()">
							×
						</h4>
						<h4 class="padding-top-8 padding-bottom-8">
							<i class="fas fa-calendar-alt"></i>
							<span style="padding-left:12px;">{{trans('my/bauk/attendance/hints.modal.endDate')}}</span>
						</h4>
					</header>
					<div id="endsmall-modal-container" class="datepicker-inline-container"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="w3-container">
		<div class="w3-col s12 m6 l6">
			<div class="input-group">
				<label><i class="fas fa-list-ul fa-fw"></i></label>
				<input id="consent-type" name="consent_type" type="text" class="w3-input" 
					value="{{old('consent_type', $consent? $consent->consent : '')}}"
					role="select"
					select-dropdown="#consent-type-dropdown"
					select-modal="#consent-type-modal"
					select-modal-container="#consent-type-modal-container" />
			</div>
			@include('my.bauk.attendance.consent_history_consent_type_dropdown')
			@include('my.bauk.attendance.consent_history_consent_type_modal')
			@if ($errors->has('consent_type'))
				<label class="padding-left-8 w3-text-red" style="font-size:.8em">
					<span>{{ $errors->first('consent_type') }}<span>
				</label>
			@else
			<label>&nbsp;</label>
			@endif
		</div>
		<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
			<?php 
				$errorUpload= count(preg_grep('/file\.*/', array_keys($errors->getMessages()))) > 0;
			?>
			<div class="input-group {{!$errorUpload?: 'error'}}">
				<label for="upload-file" style="cursor:pointer"><i class="fas fa-upload fa-fw"></i></label>
				<label for="upload-file" style="cursor:pointer; width:100%">{{ trans('my/bauk/attendance/hints.buttons.select-upload-file') }}</label>
			</div>
			<label class="padding-left-8" style="font-size:.8em">
				<span>{{trans('my/bauk/attendance/hints.buttons.type-upload-file')}}</span>
				{{-- check if no file uploaded --}}
				@if ($errorUpload)
					<div class="padding-left-8 w3-text-red">
						{{ trans('my/bauk/attendance/hints.errors.noFileUploaded') }}
					</div>
				@endif
			</label>		
			<label>&nbsp;</label>
			<input id="upload-file" 
				name="upload_file" 
				accept="{{$upload_mime}}" 
				class="w3-input w3-hide" 
				type="file"
				onchange="app.upload.handleUpload($(this).prop('files')[0])" />
		</div>
	</div>
	<div class="w3-container padding-top-8">
		<div class="w3-responsive">
			<table id="upload-file-table" class="w3-table w3-table-all">
				<thead>
					<tr class="w3-theme-l1">
						<th colspan="2">File</th>
						<th width="150px" style="text-align:center">Size (Bytes)</th>
						<th width="50px">{{-- action --}}</th>
					</tr>
				</thead>
				<tbody id="upload-file-table-body"></tbody>
				@if (!$consent)
				<tbody id="empty-table-body">
					<tr>
						<td colspan="4">Upload dokumen Cuti/Izin</td>
					</tr>
				</tbody>
				@endif
			</table>
		</div>
	</div>
	<div class="w3-container padding-top-bottom-8" style="text-align:right">
		<button class="w3-button w3-red w3-hover-red w3-mobile" 
			onclick="$(this).find('i').attr('class','button-icon-loader-red'); document.location='{{$back_action}}'"
			type="button">
			<i class="fas fa-times"></i>
			<span class="padding-left-8">Batal</span>
		</button>
		<span class="margin-left-8 w3-hide-small"></span>
		<button class="w3-button w3-blue w3-hover-blue w3-hover-none w3-mobile margin-top-8 margin-none-medium margin-none-large" 
			onclick="$(this).find('i').attr('class','button-icon-loader'); $('#submitForm').submit()"
			type="button">
			<i class="fas fa-cloud-upload-alt"></i>
			<span class="padding-left-8">Simpan</span>
		</button>
	</div>
</form>