@extends('layouts.dashboard.dashboard', ['title'=>trans('my/bauk/assignment.title'), 'sidebar'=>'bauk'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-card">
		<header class="w3-container padding-top-bottom-8 w3-theme">
			<h4>{{trans('my/bauk/assignment.subtitle')}}</h4>
		</header>
		<div class="w3-container">
			<div class="w3-col s12 m4 l4">
				<div class="input-group padding-left-8 padding-none-small">
					<label><i class="fas fa-university"></i></label>
					<input id="division" 
						name="division" 
						type="text" 
						class="w3-input" 
						value="{{old('division', isset($division)? $division : '')}}" 
						select-role="dropdown"
						select-dropdown="#division-dropdown" 
						select-modal="#division-modal"
						select-modal-container="#division-modal-container" />
				</div>
				@include('my.bauk.assignment.landing_division_dropdown_and_modal')
			</div>
		</div>
		<div class="w3-container margin-top-16">
			<div class="w3-bar w3-theme-l2">
				<button class="w3-bar-item w3-button w3-blue" target="#unassigned">Belum Bertugas</button>
				<button class="w3-bar-item w3-button" target="#assigned">Telah Bertugas</button>
			</div>
		</div>
		<div class="w3-container">
			<div id="unassigned" class="employee-list">
				<table>
					<thead>
						<tr>
							<td>NIP</td>
							<td>Nama</td>
						</tr>
					</thead>
					<tbody>
						@foreach($unassigned as $employee)
						<tr>
							<td>{{ $employee->nip }}</td>
							<td>{{ $employee->asPerson->getFullName() }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div id="assigned" class="employee-list" style="display:none">
			  <h2>Paris</h2>
			  <p>Paris is the capital of France.</p>
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
		console.log($(this).next());
	}).select();
	
	$('.w3-bar-item').click(function(){
		$('.w3-bar-item').each(function(index,item){
			$(item).removeClass('w3-blue');
			$($(this).attr('target')).css('display','none');
		});
		$(this).toggleClass('w3-blue');
		$($(this).attr('target')).css('display','block');
	});
});
</script>
@endSection