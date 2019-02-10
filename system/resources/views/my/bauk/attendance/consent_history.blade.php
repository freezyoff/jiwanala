@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.consent')}}</h4>
	</header>
	<div class="w3-row">	
		<form id="submitForm" method="post" action="{{ $post_action }}">
			@csrf
			<input name="employee_id" value="{{$employee->id}}" type="hidden" />
			<input name="employee_nip" value="{{$employee->nip}}" type="hidden" />
			<input name="date" value="{{$date->format('Y-m-d')}}" type="hidden" />
			<input name="end" value="{{ old('end', $consent? \Carbon\Carbon::createFromFormat('Y-m-d', $consent->end)->format('d-m-Y') : $date->format('d-m-Y'))  }}" type="hidden" />
			<input name="consent_record_id" value="{{$consent? $consent->id : ''}}" type="hidden" />
			<input name="back_action" value="{{$back_action}}" type="hidden" />
			<div class="w3-container padding-top-8">
				<div class="w3-col s12 m6 l4">
					<div class="input-group">
						<label><i class="fas fa-user-circle fa-fw"></i></label>
						<label style="width:100%">{{$employee->nip}}</label>
					</div>
					<label>&nbsp;</label>
				</div>
				<div class="w3-col s12 m6 l4 padding-left-8 padding-none-small">
					<div class="input-group">
						<label><i class="fas fa-font fa-fw"></i></label>
						<label style="width:100%">{{$employee->getFullName()}}</label>
					</div>
					<label>&nbsp;</label>
				</div>
			</div>
			<div class="w3-container">
				<div class="w3-col s12 m6 l4">
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
				<div class="w3-col s12 m6 l4 padding-left-8 padding-none-small">
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
								<span class="w3-button w3-display-topright w3-small w3-hover-none w3-hover-text-light-grey"
									onclick="$('#endsmall-modal').hide()" 
									style="font-size:20px !important">
									×
								</span>
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
				<div class="w3-col s12 m6 l4">
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
				<div class="w3-col s12 m6 l4 padding-left-8 padding-none-small">
					<?php 
						$errorUpload= count(preg_grep('/file\.*/', array_keys($errors->getMessages()))) > 0;
					?>
					<div class="input-group {{!$errorUpload?: 'error'}}">
						<label for="upload-file" style="cursor:pointer"><i class="fas fa-upload fa-fw"></i></label>
						<label for="upload-file" style="cursor:pointer; width:100%">{{ trans('my/bauk/attendance/hints.buttons.select-upload-file') }}</label>
					</div>
					<label class="padding-left-8" style="font-size:.8em">
						<span>{{ trans('my/bauk/attendance/hints.buttons.type-upload-file') }}<span>
						
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
					</table>
				</div>
			</div>
		</form>
	</div>
	<footer class="w3-container padding-bottom-16 padding-top-16">
		<button class="w3-button w3-red w3-hover-red" 
			onclick="$(this).find('i').attr('class','button-icon-loader-red'); document.location='{{$back_action}}'"
			type="button">
			<i class="fas fa-times"></i>
			<span class="padding-left-8">Batal</span>
		</button>
		<button class="w3-button w3-blue w3-hover-blue w3-hover-none margin-left-8" 
			onclick="$(this).find('i').attr('class','button-icon-loader'); $('#submitForm').submit()"
			type="button">
			<i class="fas fa-cloud-upload-alt"></i>
			<span class="padding-left-8">Simpan</span>
		</button>
	</footer>
	@include('my.bauk/attendance.consent_history_file_viewer')
</div>
@endSection

@section('html.head.scripts')
@parent
<script src="{{url('js/datepicker.js')}}"></script>
@endSection

@section('html.head.styles')
@parent
<link rel="stylesheet" href="{{url('css/datepicker.css')}}">
@endSection

@section('html.body.scripts')
@parent
<script>
var app = {};
app.upload = {
	init: function(){ 
		//create row from database records
		var dbFileRecords = [
			@foreach(($consent? $consent->attachments()->get() : []) as $item)
				{!! json_encode(['recordId'=>$item->id, 'size'=>$item->size, 'mime'=>$item->mime]).',' !!}
			@endforeach
		];
		$.each(dbFileRecords, function(index, item){
			var rowid = new Date().getTime(),
				disk = 'db',
				filename = 'dokumen '+(index+1);
				
			app.upload.createRow(rowid, 'dokumen '+(index+1), item.mime, item.size);
			app.upload.updateRowSuccessUpload(rowid, disk, item.recordId, 'dokumen '+(index+1), item.size, item.mime);
		});
		
		//create row from old input fields
		var uploadedFiles = [
			@foreach( old('file',[]) as $key=>$value )
				@if ($key == 'upload-file-predefined') 
					@continue
				@endif
				{!! json_encode(['fileId'=>$key, 'disk'=>$value['disk'], 'name'=>$value['name'], 'path'=>$value['path'], 'mime'=>$value['mime']]).',' !!}
			@endforeach
		];
		$.each( uploadedFiles, function(index, item){
			app.upload.createRow(item.fileId, item.name, item.mime, item.size);
			app.upload.createUploadFileField(item.fieldId, item.disk, item.path, item.name, item.mime);
		});
		
		this.createDummyRowIfNecessary();
	},
	container: $('#upload-file-table-body'),
	createCol1: function(filename, mime, root){	
		var regex = /image/i;
		$('<td id="'+ root.attr('id') +'-col1" width="10px"></td>').append(
				mime? 
				$('<i class="fas fa-file-'+ (regex.test(mime)? 'image' : 'pdf') +' fa-fw"></i>') : 
				$('<i class="button-icon-loader"></i>') 
			)
			.appendTo(root);
		$('<td id="'+ root.attr('id') +'-col2">'+filename+'</td>').appendTo(root);
	},
	createCol2: function(size, root){
		$('<td id="'+ root.attr('id') +'-col3" style="text-align:right">'+ (size? size : '')+'</td>').appendTo(root);
	},
	createCol3: function(root){
		var col = $('<td id="'+ root.attr('id') +'-col4" width="20" style="text-align:right">').appendTo(root);
		var button = $('<a class="icon">').append($('<i class="fas fa-trash-alt fa-fw w3-hover-text-red"></i>'))
			.click(function(event){
				event.stopPropagation();
				root.fadeOut("normal", function() {
					$(this).remove();
					app.upload.createDummyRowIfNecessary();
				});
			})
			.appendTo(col);
	},
	createRow: function(clientRequestId, filename, mime, size){
		var row = $('<tr id="'+clientRequestId+'" style="cursor:pointer"></tr>').appendTo(this.container);
		this.createCol1(filename, mime, row);
		this.createCol2(size, row);
		this.createCol3(row);
		return row;
	},
	createUploadFileField: function(fieldId, disk, filepath, filename, mime){
		return [ 
			$('<input name="file['+ fieldId +'][disk]" value="'+ disk +'" type="hidden" />'), 
			$('<input name="file['+ fieldId +'][name]" value="'+ filename +'" type="hidden" />'),
			$('<input name="file['+ fieldId +'][path]" value="'+ filepath +'" type="hidden" />'),
			$('<input name="file['+ fieldId +'][mime]" value="'+ mime +'" type="hidden" />')
		];
	},
	createDummyRowIfNecessary: function(){
		if (this.container.children().length<=0) {
			var id = 'upload-file-predefined';
			var row = this.createRow(id).addClass('w3-hide');
			
			//append dummy input on last column
			$.each(this.createUploadFileField(id, '', '', '' ,''), function( index, value ) {
				row.find('td:last').append(value);
			});
		}
	},
	removeDummyRow: function(){
		$('#upload-file-predefined').remove();
	},
	beforUpload: function(clientRequestId){
		var filename = $('#upload-file').val().split('\\').pop();
		app.upload.createRow(clientRequestId, filename,);
	},
	updateRowSuccessUpload: function(clientRequestId, disk, filename, clientName, size, mime){
		var successRow = this.createRow(clientRequestId, clientName, mime, size)
			.click(app.upload.updateRowSuccessUpload_rowClick);
		$('#'+clientRequestId).replaceWith( successRow );
		
		var inputFields = this.createUploadFileField(clientRequestId, disk, filename, clientName, mime);
		$.each(inputFields, function( index, value ) {
			$('#'+clientRequestId+'-col4').append(value);
		});
	},
	updateRowSuccessUpload_rowClick: function(){
		var el = $(this);
		var inputList = el.find('#'+$(this).attr('id')+'-col4').find('input');
		var formData = new FormData();
		formData.append('_token', '{{ csrf_token() }}');
		$.each(inputList, function(index, item){
			var key = $(item).attr('name').replace('file['+el.attr('id')+']', '')
						.replace('[','')
						.replace(']','');
			formData.append(key, $(item).val());
		});
		
		$.ajax({
			url: '{{route('my.bauk.attendance.consents.preview')}}',
			method: 'POST',
			data: formData,
			processData: false, // important
			contentType: false, // important
			beforeSend: function(){
				app.misc.showLoader();
			},
			success:function(response, text){
				if (response.tag){
					app.misc.documentViewer(response.mime, response.tag);
				}
			}
		});
	},
	updateRowFailedUpload: function(clientRequestId, message){
		$('#'+clientRequestId).addClass('w3-red').click(function(){
			$(this).fadeOut("normal", function(){$(this).remove();});
		});
		$('#'+clientRequestId+'-col1').find('i').attr('class','fas fa-times fa-fw');
		$('#'+clientRequestId+'-col2').append($('<div>'+message+'</div>'));
		$('#'+clientRequestId+'-col4').empty();
	},
	getFormData: function(file){
		var formData = new FormData();
		formData.append('upload_max_size', '{{$upload_max_size}}');
		formData.append('upload_mime', '{{$upload_mime}}');
		formData.append('upload_file', file);
		formData.append('_token', '{{ csrf_token() }}');
		formData.append('clientRequestId', Math.floor(Date.now() / 1000));
		return formData;
	},
	//prepare the upload ajax
	handleUpload: function(file){
		var formData = app.upload.getFormData(file);
		$.ajax({
			url: "{{ $upload_action }}",
			data: formData,
			type: 'POST',
			processData: false, // important
			contentType: false, // important
			beforeSend: function(ax, bx){
				app.upload.beforUpload( formData.get('clientRequestId') );
			},
			error: function(response, exception){
				//http error
				if ($.inArray(response.status, [412,415,500]) > -1 ){ 
					var json = response.responseJSON;
					app.upload.updateRowFailedUpload(json.clientRequestId, json.message); 
				}
				else if (response.status == 403){
					app.upload.updateRowFailedUpload(
						formData.get('clientRequestId'), 
						'{{trans('my/bauk/attendance/hints.errors.uploadFileTooLarge')}}'
					);
				}
				//no connection, timeout or forbidden
				else {	
					var message = response.status==403? 
									'{{trans('my/bauk/attendance/hints.errors.uploadFileTooLarge')}}' : 
									'{{trans('my/bauk/attendance/hints.errors.uploadConnectionTimeout')}}';
									
					app.upload.updateRowFailedUpload(formData.get('clientRequestId'), message);
				}
			},
			success: function(response){
				app.upload.updateRowSuccessUpload(
					response.clientRequestId,
					response.remote.disk, 
					response.remote.path, 
					response.info.name, 
					response.info.size,
					response.info.mime,
					response.remote.base64
				); 
				
				//remove dummy upload on successfull upload
				app.upload.removeDummyRow();
			}
		});
	}
};

app.misc = {
	viewContainer: $('#viewer-modal'),
	fileContainer: $('#viewer-modal-file'),
	showLoader:function(){
		app.misc.fileContainer.empty()
			.append(
				$('<i></i>').addClass('button-icon-loader')
					.css({
						position: 'relative',
						margin: 'auto',
						width: '120px',
						height: '120px',
						'border-top-width': '12px',
						'border-bottom-width': '12px',
						'border-left-width': '12px',
						'border-right-width': '12px',
						left: '20%',
						top: '20%'
					})
			);
		var w = app.misc.fileContainer.children().width(),
			h = app.misc.fileContainer.children().height(),
			offset = 100;
		app.misc.viewContainer.show();
		app.misc.fileContainer.css({width: w+offset, height: h+offset});
	},
	documentViewer: function(mime, tag){
		$(tag).ready(function(){	//we wait untill ready
			app.misc.fileContainer.empty().css('width','');
			app.misc.fileContainer.append(tag).children().css('width','100%');
			
			var offset = parseInt($('#viewer-modal').css('padding-top')),
				maxHeight = $(window).height() - (offset*2);
			if (mime.includes('image')) {
				app.misc.fileContainer.children().css('max-height', maxHeight);
			}
			else if (mime.includes('pdf')) {
				app.misc.fileContainer.children().css(app.misc.calcPdfViewSize());
			}
		});
	},
	calcPdfViewSize: function(){
		var offset = parseInt($('#viewer-modal').css('padding-top'));
		return {
			height: $(window).height() - (offset*2)
		};
	}
};

app.datepicker= {
	init: function(){
		var startDate = '{{$date->format('d-m-Y')}}';
		var datepickerFloat = {format: 'dd-mm-yyyy', offset: 5, autoHide:true, language: 'id-ID', startDate: startDate};
		$('[role="datepicker-dropdown"]').each(function(index, item){
			$(window).resize(app.datepicker.windowResize);
			$(item).datepicker(datepickerFloat)
				.on('click focusin', app.datepicker.click)
				.on('pick.datepicker', app.datepicker.pick);
		});
		
		var datepickerModal = {format: 'dd-mm-yyyy', offset: 5, container: '', inline: true, language: 'id-ID', startDate: startDate};
		$('[role="datepicker-modal"]').each(function(index, item){
			$(window).resize(app.datepicker.windowResize);
			$(item).datepicker( $.extend(datepickerModal, {container: $(item).attr('datepicker-container') }) )
				.on('click focusin', app.datepicker.showModal)
				.on('pick.datepicker', app.datepicker.pick);
		});
	},
	syncValue: function(datepicker, value){
		$( datepicker.attr('datepicker-value') ).val(value);
		$( datepicker.attr('datepicker-link') ).val(value);
	},
	hideDatepicker: function(target){
		if ($(target).attr('datepicker-modal')) $( $(target).attr('datepicker-modal') ).hide();
		else $(target).datepicker('hide');
	},
	pick: function(event){
		app.datepicker.syncValue($(this), $(this).datepicker('getDate',true));
		app.datepicker.hideDatepicker($(event.target));
	},
	click: function(event){
		event.stopPropagation();
		$( $(this).attr('datepicker-link') ).trigger('click');
	},
	windowResize: function(event){
		$('[role="datepicker-dropdown"], [role="datepicker-modal"]').each(function(ind,item){
			app.datepicker.hideDatepicker(item);
		});
	},
	showModal: function(event){
		app.datepicker.click(event);
		event.stopPropagation();
		$( $(this).attr('datepicker-modal') ).show();
	}
};

$(document).ready(function(){ 
	app.upload.init();
	app.datepicker.init();
	$('[role="select"]').select();
});
</script>
@endSection