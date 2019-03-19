@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/assignment.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-card">
		<header class="w3-container padding-top-bottom-8 w3-theme">
			<h4>{{trans('my/bauk/assignment.subtitle')}}</h4>
		</header>
		<div class="w3-container">
			<form action="{{route('my.bauk.assignment.landing')}}" method="POST">
				@csrf
				<div class="w3-col s12 m4 l4">
					<div class="input-group padding-left-8 padding-none-small">
						<label><i class="fas fa-university"></i></label>
						<input id="division" 
							name="division" 
							type="text" 
							class="w3-input" 
							value="{{old('division', isset($division)? $division->code : '')}}" 
							select-role="dropdown"
							select-dropdown="#division-dropdown" 
							select-modal="#division-modal"
							select-modal-container="#division-modal-container" />
					</div>
					@include('my.bauk.assignment.landing_division_dropdown_and_modal')
				</div>
			</form>
		</div>
		<div class="w3-container margin-top-16">
			<div class="w3-bar w3-theme-l2">
				<button class="w3-bar-item w3-button w3-blue" target="#unassigned">Belum Bertugas</button>
				<button class="w3-bar-item w3-button" target="#assigned">Telah Bertugas</button>
			</div>
		</div>
		<div class="w3-container padding-bottom-16">
			<div id="unassigned" class="employee-list">
				<table class="w3-table w3-table-all">
					<thead>
						<tr class="w3-theme">
							<td>NIP</td>
							<td>Nama</td>
						</tr>
					</thead>
					<tbody>
						@foreach($unassigned as $employee)
						<tr>
							<td>{{ $employee->nip }}</td>
							<td>{{ $employee->getFullName() }}</td>
							<td>
								@if (\Auth::guard('my')->user()->hasPermission('bauk.assignment.assign'))
								<a class="action" 
									title="{{"tugaskan ke ".$division->name}}"
									toggle="#action-dropdown-{{$employee->id}}"
									style="cursor:pointer">
									<i class="fas fa-running"></i>
								</a>
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div id="assigned" class="employee-list" style="display:none">
			  <table class="w3-table w3-table-all">
					<thead>
						<tr class="w3-theme">
							<td>NIP</td>
							<td>Nama</td>
						</tr>
					</thead>
					<tbody>
						@foreach($assigned as $employee)
						<tr>
							<td>{{ $employee->nip }}</td>
							<td>{{ $employee->getFullName() }}</td>
							<td></td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('#division').change(function(){
		$(this).parents('form').trigger('submit');
	}).select();
	
	$('.w3-bar-item').click(function(){
		$('.w3-bar-item').each(function(index,item){
			$(item).removeClass('w3-blue');
			$($(this).attr('target')).css('display','none');
		});
		$(this).toggleClass('w3-blue');
		$($(this).attr('target')).css('display','block');
	});
	
	$('.action').click(function(){
		$($(this).attr('toggle')).toggle();
	});
});
</script>
@endSection