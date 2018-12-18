@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/employee/landing.page.title')])

@section('dashboard.main')
<!--
<div style="padding-bottom:16px;">
	<div></div>
	<a class="accordion" href="#" target="searchForm" style="cursor:pointer;">Opsi pencarian data</a>
	<div id="searchForm">@TODO</div>
</div>
-->
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
							<span class="padding-left-8 padding-right-8" 
								title="{{$data->workTime()}}">
							@if($data->isWorkTime('f'))
								<i class="fas fa-handshake w3-large w3-text-brown"></i>
							@elseif($data->isWorkTime('p'))
								<i class="fas fa-hands-helping w3-large w3-text-teal"></i>
							@endif
							</span>
							
							@if ($data->isActive())
								<a href="{{route('my.bauk.employee.activate',[$data->id,0])}}" 
									style="text-decoration:none;"
									class="w3-large w3-hover-text-indigo" 
									title="Klik untuk menonaktifkan karyawan">
									<i class="fas fa-lightbulb"></i>
								</a>
							@else
								<a href="{{route('my.bauk.employee.activate',[$data->id,1])}}" 
									style="text-decoration:none;"
									class="w3-large w3-hover-text-black" 
									title="Klik untuk mengaktifkan karyawan">
									<i class="far fa-lightbulb"></i>
								</a>
							@endif
						</td>
						<td><span>+62 </span>{{$data->phone}}</td>
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

@section('html.body.scripts')
@parent
<script>
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

$(document).ready(function(){
	App.UI.searchActivation();
});
</script>
@endSection