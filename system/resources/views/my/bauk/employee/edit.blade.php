@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>'Manajemen Karyawan'])

@section('dashboard.main')
<div class="w3-row" style="padding-bottom:16px; ">
	<form id="form1" 
		method="post" 
		action="{{route('my.bauk.employee.edit',['id'=>$data->id])}}">
		<input name="employee_id" type="hidden" value="{{$data->id}}" />
		@csrf
		<div class="w3-card w3-round w3-col s12 m12 l8 ">
			<header class="w3-container w3-theme-l1 padding-top-bottom-8">
				<h4>Rubah Data Karyawan</h4>
			</header>
			<div class="w3-container">
				<div class="padding-top-16 padding-bottom-8">
						<!-- begin: input nip -->
						<div class="input-group">
							<label><i class="fas fa-id-badge fa-fw"></i></label>
							<input name="nip" type="text" 
								value="{{old('nip', $data->nip)}}" 
								placeholder="{{trans('my/bauk/employee/add.hints.nip')}}" 
								class="w3-input
								@if(isset($errors) && $errors->has('nip'))
									error
								@endif
								" />
						</div>
						@if(isset($errors) && $errors->has('nip'))
							<label class="w3-text-red">{{$errors->first('nip')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
						<!-- end: input nip -->
						<!-- begin: input nik -->
						<div class="input-group">
							<label><i class="fas fa-id-card fa-fw"></i></label>
							<input name="nik" type="text" 
								value="{{old('nik', $data->asPerson()->first()->nik)}}" 
								placeholder="{{trans('my/bauk/employee/add.hints.nik')}}" 
								class="w3-input
								@if(isset($errors) && $errors->has('nik'))
									error
								@endif
								"/>
						</div>
						@if(isset($errors) && $errors->has('nik'))
							<label class="w3-text-red">{{$errors->first('nik')}}</label>
						@else
							<label>&nbsp;</label>
						@endif
						<!-- end: input nik -->
						<!-- begin: input name -->
						<div id="name-with-titles">@include('my.bauk.employee.edit_name_with_titles',['data'=>$data->asPerson()->first()])</div>
						<!-- end: input name -->
						<!-- begin: input name -->
						<div id="birth-place">@include('my.bauk.employee.edit_birth_place_and_date',['data'=>$data->asPerson()->first()])</div>
						<!-- end: input name -->
						<!-- begin: input phone -->
						<div id="address-container">
						<?php
							$loop = old('address',false);
							if (!$loop){
								$loop = $data->asPerson()->first()->addresses()->get();
							}
							//@for ($i = 0; $i < count($loop); $i++)
						?>
							@foreach($loop as $index=>$value)
								@include('my.bauk.employee.edit_address',['index'=>$index, 'address'=>$value])
							@endforeach
						</div>
						<div class="padding-bottom-16 padding-left-8">
							<a href="#" class="w3-hover-text-blue" style="text-decoration:none; cursor:pointer" 
								onclick="event.preventDefault(); UI.address.add();">
								<i class="fas fa-plus-square"></i>
								<span class="padding-left-8">Tambah Alamat</span>
							</a>
						</div>
						<!-- end: input phone -->
						<!-- begin: input phone -->
						<div id="phone-container">
						<?php
							$loop = old('phone',false);
							if (!$loop){
								$loop = $data->asPerson()->first()->phones()->get();
							}
						?>
							@for ($i = 0; $i < count($loop); $i++)
								@include('my.bauk.employee.edit_phone',['index'=>$i, 'phone'=>$loop[$i]])
							@endfor
						</div>
						<div class="padding-bottom-16 padding-left-8">
							<a href="#" class="w3-hover-text-blue" style="text-decoration:none; cursor:pointer" 
								onclick="event.preventDefault(); UI.phone.add();">
								<i class="fas fa-plus-square"></i>
								<span class="padding-left-8">Tambah Telepon</span>
							</a>
						</div>
						<!-- end: input phone -->
						<!-- begin: input email -->
						<div id="email-container" class="w3-row">
						<?php
							$loop = old('email',false);
							if (!$loop){
								$loop = $data->asPerson()->first()->emails()->get();
							}
						?>
							@for ($i = 0; $i < count($loop); $i++)
								@include('my.bauk.employee.edit_email',['index'=>$i, 'email'=>$loop[$i]])
							@endfor
						</div>
						<div class="w3-row padding-bottom-16 padding-left-8">
							<a href="#" class="w3-hover-text-blue" style="text-decoration:none; cursor:pointer" 
								onclick="event.preventDefault(); UI.email.add();">
								<i class="fas fa-plus-square"></i>
								<span class="padding-left-8">Tambah Email</span>
							</a>
						</div>
						<!-- end: input email -->
						<!-- begin: input work time & registered-->
						<div id="name-with-titles">@include('my.bauk.employee.edit_worktime_and_registered_at')</div>
						<!-- end: input work time & registered -->
				</div>
				<div class="w3-hide-small padding-bottom-16 padding-top-16" style="text-align:right">
					<button id="btn-cancel-large" class="w3-button w3-red w3-hover-red" type="button" onclick="document.location='{{route('my.bauk.employee.landing')}}'">
						<i class="fas fa-times"></i>
						<span class="padding-left-8">Batal</span>
					</button>
					<button id="btn-save-large" class="w3-button w3-blue w3-hover-blue w3-hover-none margin-left-8" type="submit">
						<i class="fas fa-cloud-upload-alt"></i>
						<span class="padding-left-8">Simpan</span>
					</button>
					<button id="btn-loader-large" class="w3-button w3-blue w3-mobile w3-hover-blue" type="button">
						<i class="button-icon-loader"></i>
						<span class="padding-left-8">Simpan</span>
					</button>
				</div>
				<div class="w3-hide-large w3-hide-medium padding-top-8 padding-bottom-16" style="text-align:right">
					<button id="btn-cancel-small" class="w3-button w3-red w3-mobile w3-hover-red" type="button" onclick="document.location='{{route('my.bauk.employee.landing')}}'">
						<i class="fas fa-times"></i>
						<span class="padding-left-8">Batal</span>
					</button>
					<button id="btn-save-small" class="w3-button w3-blue w3-mobile w3-hover-blue margin-top-bottom-8" type="submit">
						<i class="fas fa-cloud-upload-alt"></i>
						<span class="padding-left-8">Simpan</span>
					</button>
					<button id="btn-loader-small" class="w3-button w3-blue w3-mobile w3-hover-blue margin-top-bottom-8" type="button">
						<i class="button-icon-loader"></i>
						<span class="padding-left-8">Simpan</span>
					</button>
				</div>
			</div>			
		</div>
	</form>
	<div class="w3-hide-small w3-hide-medium w3-col l4 padding-left-16">
		@include('my.bauk.employee.add_help')
	</div>
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
var UI = {};
UI.phone = {
	add: function (){
		$('#phone-container').append(@include('my.bauk.employee.add_phone_json'));
	},
	remove: function (inputGroup){
		//inputGroup.next().remove();
		inputGroup.remove();
	},
};

UI.email = {
	add: function (){
		var line = $(@include('my.bauk.employee.add_email_json')),
			count = $('#email-container').children().length;
		if (count%2==0) line.removeClass('padding-left-8');
		$('#email-container').append(line);
	},
	remove: function (inputGroup){
		//inputGroup.next().remove();
		inputGroup.remove();
	},
};

UI.address={
	add:function(){
		$('#address-container').append(@include('my.bauk.employee.add_address_json'));
	},
	remove:function(inputGroup){
		inputGroup.remove();
	}
};

UI.worktime = {
	init: function(){
		//work_time dropdown large
		$('#worktime-dropdown .w3-ul li')
			.click(UI.worktime.itemClick)
			.click(UI.worktime.dropdownToggle);
		$('input[name=work_time_large]').on('focusin',UI.worktime.dropdownToggle);
		$('button.w3-button.w3-hide-small.w3-hide-medium').on('click',UI.worktime.dropdownToggle);
		
		//work_time dropdown small
		$('#worktime-modal .w3-bar-block .w3-ul li').click(UI.worktime.itemClick);
		$('input[name=work_time_small]').on('focusin',UI.worktime.modalToggle)
			.next() //the button;
			.on('click',UI.worktime.modalToggle);
	},
	modalToggle:function(){
		$('#worktime-modal').show();
	},
	dropdownToggle:function(){
		var dropdown = $('#worktime-dropdown');
		dropdown.width($(this).parent().width());
		if (dropdown.css('display') == 'block') {
			dropdown.removeClass('w3-show');
			$('button.w3-button.w3-hide-small.w3-hide-medium>i')
				.removeClass('fa-chevron-up')
				.addClass('fa-chevron-down');
		}
		else {			
			dropdown.addClass('w3-show');
			$('button.w3-button.w3-hide-small.w3-hide-medium>i')
				.removeClass('fa-chevron-down')
				.addClass('fa-chevron-up');
		}
	},
	itemClick: function(){
		var item = $(this).children('a');
		UI.worktime.set(item.attr('data-value'), item.children('span').text());
	},
	set:function(value, display){
		$('input[name=work_time]').val(value);
		$('input[name=work_time_large]').val(display);
		$('input[name=work_time_small]').val(display);
	}
};

UI.datepicker = {
	format: {
		float:{ format: 'dd-mm-yyyy', offset: 5, language: 'id-ID', autoHide:true },
		inline: { format: 'dd-mm-yyyy', offset: 5, container: '#datepicker-inline-container', inline: true, language: 'id-ID'}
	},
	click:{
		float: function(e){
			if(e.view == 'day') {
				var td = $(e.target).datepicker('getDate');
			}
			$(e.target).trigger('date-change');
		},
		inline:function(e){
			if(e.view == 'day') {
				$('.w3-modal').hide();
				UI.datepicker.click.float(e);
			}
		}
	},
	change:{
		
	},
	init: function(){
		var datepickerValueChange={
			birthDate: function(e){
				var tds = $(e.target).val();
				$('#birth_date').val(tds);
				
				var el = $('input[name="birth_date_large"]');
				el.val(tds);
				
				el = $('input[name="birth_date_small"]');
				el.val(tds);
			},
			registeredAt:function(e){
				var tds = $(e.target).val();
				$('#registered_at').attr('value', tds);
				
				var el = $('input[name="registered_at_large"]');
				el.val(tds);
				
				el = $('input[name="registered_at_small"]');
				el.val(tds);
			}
		};
		
		$('[data-toggle="datepicker"]').datepicker(UI.datepicker.format.float)
			.on('pick.datepicker', UI.datepicker.click.float)
			.on('date-change change keyup', datepickerValueChange.birthDate);
		$('[data-toggle="datepicker-inline"]').datepicker(
			$.extend(UI.datepicker.format.inline, {container: '#datepicker-inline-container'})
		).on('pick.datepicker', UI.datepicker.click.inline)
		 .on('date-change change keyup', datepickerValueChange.birthDate);
		
		$('[data-toggle="datepicker-registeredAt"]').datepicker(UI.datepicker.format.float)
			.on('pick.datepicker', UI.datepicker.click.float)
			.on('date-change change keyup', datepickerValueChange.registeredAt);
		
		$('[data-toggle="datepicker-inline-registeredAt"]').datepicker(
			$.extend(UI.datepicker.format.inline, {container: '#datepicker-inline-container-registeredAt'})
		).on('pick.datepicker', UI.datepicker.click.inline)
		 .on('date-change change keyup', datepickerValueChange.registeredAt);
	}
};

UI.actionButton={
	id:{
		save:['#btn-save-large', '#btn-save-small'],
		cancel:['#btn-cancel-large', '#btn-cancel-small'],
		loader:['#btn-loader-large', '#btn-loader-small'],
	},
	init:function(){
		this.origin();
		$(this.id.save.join(',')).click(function(event){
			UI.actionButton.submit();
		});
	},
	origin:function(){
		$(this.id.save.join(',')).show();
		$(this.id.cancel.join(',')).show();
		$(this.id.loader.join(',')).hide();
	},
	submit: function(){
		$(this.id.save.join(',')).hide();
		$(this.id.cancel.join(',')).hide();
		$(this.id.loader.join(',')).show();
	}
};

$(document).ready(function(){
	UI.worktime.init();
	UI.datepicker.init();
	UI.actionButton.init();
});
</script>
@endSection