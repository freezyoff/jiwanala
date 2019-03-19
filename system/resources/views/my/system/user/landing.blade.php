@extends('layouts.dashboard.dashboard', ['sidebar'=>'system', 'title'=>trans('my/system/user.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-bottom-8">
		<h4>{{trans('my/system/user.subtitles.landing')}}</h4>
	</header>
	<div class="padding-top-bottom-8">
		<div class="w3-row w3-container">
			<form name="search" action="{{route('my.system.user.index')}}" method="post">
				@csrf
				<div class="w3-col s12 m4 l4">
					<div class="input-group">
						<label><i class="fas fa-keyboard"></i></label>
						<input id="keywords" 
							name="keywords" 
							type="text" 
							class="w3-input" 
							placeholder="{{trans('my/system/user.hints.keywords')}}"
							value="{{old('keywords', $keywords)}}" />
					</div>
				</div>
				<div class="w3-col s12 m4 l4 padding-left-8 padding-none-small">
					<div class="input-group padding-left-8 padding-none-small">
						<label><i class="fas fa-lightbulb fa-fw"></i></label>
						<input id="employeeActive" 
							name="active_status" 
							type="text"
							class="w3-input" 
							value="{{ old('active_status', $active_status) }}" 
							select-role="dropdown"
							select-dropdown="#employeeActive-dropdown" 
							select-modal="#employeeActive-modal"
							select-modal-container="#employeeActive-modal-container" />
					</div>
					@include('my.system.user.landing_employeeActive_dropdown_modal')
				</div>
			</form>
		</div>
		<div class="w3-row w3-container margin-top-16">
			<div class="w3-col s12 m12 l12">
				<div class="w3-container">
					{{$employees->links('layouts.dashboard.pagination')}}
				</div>
				<div class="w3-responsive">
					<table class="w3-table w3-table-all">
						<thead>
							<tr class="w3-theme-l1">
								<td class="w3-hide-large"></td>
								<td>NIP</td>
								<td>Nama</td>
								<td>Email</td>
								<td>Status</td>
								<td class="w3-hide-small w3-hide-medium"></td>
							</tr>
						</thead>
						<tbody>
							@forelse ($employees as $empl)
							<?php $emailCount= $empl->asPerson->emails()->count(); ?>
								<tr>
									<td class="w3-hide-large" style="white-space:nowrap;">
										@if ($empl->asUser)
											@if(\Auth::user()->hasPermission('system.user.patch'))
											<a class="action padding-right-8"
												style="cursor:pointer"
												title="{{trans('my/system/user.hints.reset')}}"
												alt="{{trans('my/system/user.hints.reset')}}"
												href="{{route('my.system.user.resetPwd',['id'=>$empl->asUser->id])}}">
												<i class="fas fa-undo"></i>
											</a>
											@elseif(\Auth::user()->hasPermission('system.user.delete'))
											<a class="action"
												style="cursor:pointer"
												toggle="delete-modal-{{$empl->id}}"
												title="{{trans('my/system/user.hints.delete')}}"
												alt="{{trans('my/system/user.hints.delete')}}">
												<i class="fas fa-user-slash"></i>
											</a>
											@endif
										@elseif ($empl->asPerson->emailDefault() && \Auth::user()->hasPermission('system.user.post'))
											<a class="action"
												style="cursor:pointer"
												toggle="link-modal-{{$empl->id}}" 
												title="{{trans('my/system/user.hints.delete')}}"
												alt="{{trans('my/system/user.hints.delete')}}">
												<i class="fas fa-user-shield"></i>
											</a>
											@include('my.system.user.landing_create_modal')	
										@endif
									</td>
									<td>{{$empl->nip }}</td>
									<td>{{$empl->getFullName()}}</td>
									<td>
										@if ($empl->asUser && $empl->asUser->email)
											{{$empl->asUser->email}}
										@elseif ($empl->asPerson && !$empl->asPerson->emailDefault())
											<span class="w3-tag w3-orange">{{trans('my/system/user.info.noEmail')}}</span>
										@endif
									</td>
									<td>
										@if ($empl->asUser)
											@if($empl->asUser->activated)
												<span class="w3-tag w3-green">aktif</span>
											@else
												<span class="w3-tag">terkunci</span>
											@endif
											@include('my.system.user.landing_delete_modal')
											@include('my.system.user.landing_create_modal')	
										@endif
									</td>
									<td class="w3-hide-small w3-hide-medium" style="text-align:right;white-space:nowrap">
										@if($empl->asUser)
											@if(\Auth::user()->hasPermission('system.user.patch'))
											<a class="action"
												style="cursor:pointer"
												title="{{trans('my/system/user.hints.reset')}}"
												alt="{{trans('my/system/user.hints.reset')}}"
												href="{{route('my.system.user.resetPwd',['id'=>$empl->asUser->id])}}">
												<i class="fas fa-undo"></i>
											</a>
											@endif
											@if(\Auth::user()->hasPermission('system.user.delete'))
											<a class="action padding-left-8"
												style="cursor:pointer"
												toggle="delete-modal-{{$empl->id}}"
												title="{{trans('my/system/user.hints.delete')}}"
												alt="{{trans('my/system/user.hints.delete')}}">
												<i class="fas fa-user-slash"></i>
											</a>
											@endif
										@elseif ($empl->asPerson->emailDefault() && \Auth::user()->hasPermission('system.user.post'))
											<a class="action padding-left-8" 
												style="cursor:pointer"
												toggle="link-dropdown-{{$empl->id}}"
												title="{{trans('my/system/user.hints.create')}}"
												alt="{{trans('my/system/user.hints.create')}}">
												<i class="fas fa-user-shield"></i>
											</a>
											@include('my.system.user.landing_create_dropdown')	
										@endif
									</td>
								</tr>
							@empty
								<tr>
									<td colspan="5">Belum ada data</td>
								</tr>
							@endforelse
						</tbody>
					</table>
				</div>
				<div class="w3-container">
					{{$employees->links('layouts.dashboard.pagination')}}
				</div>
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	$('[select-role="dropdown"]').select().on('select.pick', function(){
		$('form[name="search"]').submit();
	});
	
	$('a.action').click(function(event){
		event.stopPropagation();
		$('.w3-dropdown-content').hide();
		$('#'+$(this).attr('toggle')).show();
		console.log($(this).attr('toggle'));
	});
	
	$(window).click(function(){
		$('.w3-dropdown-content').hide();
	});
});
</script>
@endSection
