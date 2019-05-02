@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/employee/landing.page.title')])

@section('dashboard.main')
<div class="w3-card w3-round">
	<header class="w3-container w3-theme-l1 padding-top-bottom-8">
		<h4>{{trans('my/bauk/employee/landing.page.sub_title')}}</h4>
	</header>
	<div class="w3-container padding-bottom-16 padding-top-16" style="display:flex; align-items:center">
		<div style="flex-grow:1">
			<button class="w3-button w3-blue w3-hover-blue w3-large" onclick="document.location='{{route('my.bauk.employee.add')}}'">
				<i class="fas fa-user-plus"></i>
				<span class="padding-left-8">{{trans('my/bauk/employee/landing.btn-add')}}</span>
			</button>		
		</div>
		<div class="w3-hide-small" style="max-width:350px">
			<div class="w3-col m6 l6">
				<div class="padding-left-16">
					<i class="fas fa-handshake w3-large w3-text-brown"></i>
					<span class="padding-left-8">Full Time</span>
				</div>
			</div>
			<div class="w3-col m6 l6">
				<div class="padding-left-16">
					<i class="fas fa-lightbulb w3-large w3-text-indigo"></i>
					<span class="padding-left-8">Karyawan Aktif</span>
				</div>
			</div>
			<div class="w3-col m6 l6">
				<div class="padding-left-16">
					<i class="fas fa-hands-helping w3-large w3-text-teal"></i>
					<span class="padding-left-8">Part Time</span>
				</div>
			</div>
			<div class="w3-col m6 l6">
				<div class="padding-left-16">
					<i class="far fa-lightbulb w3-large w3-text-black"></i>
					<span class="padding-left-8">Karyawan Non-Aktif</span>
				</div>
			</div>
		</div>
	</div>
	<!--- begin: search Key --->
	<div class="w3-container padding-top-16">@include('my.bauk.employee.landing_search')</div>
	<!--- end: search Key --->
	@if ($employees->count()>0)
		<div class="w3-container padding-bottom-16">
			{{$employees->links('layouts.dashboard.pagination')}}
		</div>
	@endif
	<div class="w3-responsive w3-container" style="margin-bottom:16px">
		<table class="w3-table-all w3-hoverable" style="min-width:750px;">
			<thead>
				<tr>
					<td class="w3-theme-l1 w3-hide-large"></td>
					<td class="w3-theme-l1">NIP</td>
					<td class="w3-theme-l1">Nama</td>
					<td class="w3-theme-l1 w3-center"></td>
					<td class="w3-theme-l1">Telepon</td>
					<td class="w3-theme-l1 w3-hide-small w3-hide-medium"></td>
				</tr>
			</thead>
			<tbody>
				@if ($employees->count()>0)
					@foreach($employees as $data)
					<tr style="vertical-align:middle">
						<td class="w3-hide-large padding-left-8">@include('my.bauk.employee.landing_table_action')</td>
						<td>{{$data->nip?: ''}}</td>
						<td>{{$data->name_front_titles.' '.$data->name_full.' '.$data->name_back_titles?: ''}}</td>
						<td class="w3-center">
							<span title="{{$data->workTime()}}">
							@if($data->isWorkTime('f'))
								<i class="fas fa-handshake w3-large w3-text-brown"></i>
							@elseif($data->isWorkTime('p'))
								<i class="fas fa-hands-helping w3-large w3-text-teal"></i>
							@endif
							</span>
							
							@if ($data->isActive())
								<span class="padding-left-8 w3-text-indigo" title="Karyawan Aktif" style="font-size:1em">
									<i class="fas fa-lightbulb"></i>
								</span>
							@else
								<span class="padding-left-8 w3-text-black" title="Karyawan Non Aktif" style="font-size:1em">
									<i class="far fa-lightbulb"></i>
								</span>
							@endif
						</td>
						<td>
							<span>+62 </span>{{$data->phone}}
							@include('my.bauk.employee.landing_table_action_modal')
						</td>
						<td class="w3-hide-small w3-hide-medium w3-right-align">@include('my.bauk.employee.landing_table_action')</td>
					@endforeach
					<tr>
				@else
					<td colspan="5">Belum ada data</td>
				@endif
			</tbody>
		</table>
	</div> 
	@if ($employees->count()>0)
		<div class="w3-container padding-bottom-16">
			{{$employees->links('layouts.dashboard.pagination')}}
		</div>
	@endif
</div> 
@endSection

@section('html.head.styles')
@parent
<style>
.datepicker-modal .datepicker-inline{font-size:12px !important;}
</style>
@endSection

@section('html.body.scripts')
@parent
<script>
App.UI.keywords = function(){
	$('input[name="keywords"]').on('change', $.debounce(250, function(){
		$(this).prev().find('i').attr('class','button-icon-loader');
		$('form[name=searchkey]').submit();
	}));
};

App.UI.searchActivation = function(){
	var containerStyle = {
		largeOnWindowResize: function(){
			$('#keyactive-dropdown').width($('input[name=keyactive_large]').parent().width());
		},
		largeOnShow: function(){
			$('input[name=keyactive_large]').next().children('i')
				.addClass('fa-chevron-up')
				.removeClass('fa-chevron-down');
		},
		largeOnHide: function(){
			$('input[name=keyactive_large]').next().children('i')
				.removeClass('fa-chevron-up')
				.addClass('fa-chevron-down');
		}
	};
	
	var container = {
		show: function(){ 
			$(window).trigger('resize');
			containerStyle.largeOnShow();
			$('#keyactive-dropdown, #keyactive-modal').show();
		},
		hide: function(){ 
			containerStyle.largeOnHide();
			$('#keyactive-dropdown, #keyactive-modal').hide();  
		}
	};
	
	var valueChange=function(display, value){
		$('input[name=keyactive_large], input[name=keyactive_small]').val(display);
		$('input[name=keyactive]').val(value);
		$('form[name=searchkey]').submit();
	};
	
	//style
	$(window).resize(containerStyle.largeOnWindowResize);
	
	//container show & hide
	$('input[name=keyactive_large], input[name=keyactive_small]').on('click focus', container.show);
	
	//item click
	$('#keyactive-dropdown ul>li, #keyactive-modal ul>li').click(function(){
		var linkElement = $(this).children('a');
		valueChange(linkElement.children('span').text(), linkElement.attr('data-value'));
		container.hide();
	});
};

App.submitSearch = function(){
	$('form[name=searchkey]').submit();
};

App.deactivated = {
	show: function(id){
		$('#deactivated-modal-'+id).show();
	},
	hide:function(id){
		$('#deactivated-modal-'+id).hide();
	},
	install: function(item){
		$(item).datepicker({ 
			format: 'dd-mm-yyyy', 
			offset: 5, 
			container: '#deactivated-modal-container-'+ $(item).attr('data-id'), 
			inline: true, 
			language: 'id-ID'
		}).on('click focus', function(event){
			event.stopPropagation();
		});
	},
	init: function(){
		$('input.datepicker').each(function(index,item){
			App.deactivated.install(item);
		});
	},
	submit:function(id){
		var url = '{{route('my.bauk.employee.deactivate',['id'=>':id', 'date'=>':date'])}}';
		url = url.replace(':id', id);
		url = url.replace(':date', $('#deactivated-input-'+id).val());
		document.location=url;
	}
};

$(document).ready(function(){
	App.UI.keywords();
	$('[role="select"]').on('select.pick', App.submitSearch).select();
	App.deactivated.init();
});
</script>
@endSection