@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.upload')])

@section('dashboard.main')
<div class="w3-card margin-bottom-16">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.upload_import')}}</h4>
	</header>
	<div class="w3-row padding-top-bottom-8">
		<div class="w3-row">
			<div class="w3-col s12 m12 l12">
				<div class="w3-container padding-top-8">
					<h4>1. {{trans('my/bauk/attendance/hints.info.upload_step.0.h4')}}</h4>
					<div class="padding-left-16">
						<p>{!!trans('my/bauk/attendance/hints.info.upload_step.0.p1')!!}</p>
						<p class="padding-top-8">{!!trans('my/bauk/attendance/hints.info.upload_step.0.p2')!!}</p>
						<div class="padding-top-8">
							<div class="w3-col s12 m6 l4">
								<a href="{{route('my.bauk.attendance.download.help',['Vista_7'])}}" 
									class="w3-large w3-hover-text-indigo w3-text-indigo margin-left-8"
									style="text-decoration:none">
									<i class="fab fa-microsoft"></i>
									<span class="w3-text-theme padding-left-8">Windows Vista,&nbsp;7</span>
								</a>								
								
							</div>
							<div class="padding-left-14 w3-col w3-col s12 m6 l6">
								<a href="{{route('my.bauk.attendance.download.help',['8_10'])}}" 
									class="w3-large w3-hover-text-purple w3-text-purple margin-left-8"
									style="text-decoration:none">
									<i class="fab fa-windows fa-fw"></i>
									<span class="w3-text-theme padding-left-8">Windows 8,&nbsp;10</span>
								</a>								
							</div>
						</div>
					</div>
				</div>
				<div class="w3-container padding-top-16">
					<h4>2. {{trans('my/bauk/attendance/hints.info.upload_step.1.h4')}}</h4>
					<div class="padding-left-16">
						<p>{!!trans('my/bauk/attendance/hints.info.upload_step.1.p1')!!}</p>
						<p class="padding-top-8">{!!trans('my/bauk/attendance/hints.info.upload_step.1.p2')!!}</p>
						<div class="padding-top-8">
							<div class="w3-col s12 m6 l4">
								<a href="{{route('my.bauk.attendance.download.template',['xls'])}}" 
									class="w3-large w3-hover-text-indigo w3-text-indigo margin-left-8"
									style="text-decoration:none">
									<i class="fas fa-file-excel fa-fw"></i>
									<span class="w3-text-theme padding-left-8">Old Excel (.xls)</span>
								</a>								
							</div>
							<div class="w3-col w3-col s12 m6 l4">
								<a href="{{route('my.bauk.attendance.download.template',['xlsx'])}}" 
									class="w3-large w3-hover-text-purple w3-text-purple margin-left-8"
									style="text-decoration:none">
									<i class="fas fa-file-excel fa-fw"></i>
									<span class="w3-text-theme padding-left-8">Modern Excel (.xlsx)</span>
								</a>								
							</div>						
						</div>
					</div>
				</div>
				<div class="w3-container padding-top-16">
					<h4>3. {{trans('my/bauk/attendance/hints.info.upload_step.2.h4')}}</h4>
					<div class="padding-left-16">
						<p>{!!trans('my/bauk/attendance/hints.info.upload_step.2.p1')!!}</p>
					</div>
					<form action="{{route('my.bauk.attendance.upload')}}" name="import" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="padding-left-16 w3-col s12 m8 l6">
							<div class="input-group
								@if ($errors->has('file') || \Session::has('invalid'))
									error
								@endif
								">
								<label><i class="fas fa-upload fa-fw"></i></label>
								<label for="file" style="width:100%"><span class="w3-text-grey">{{trans('my/bauk/attendance/hints.buttons.upload-file')}}</span></label>
								<input id="file" name="file" type="file" style="display:none" accept=".csv" />
							</div>
							@if ($errors->has('file'))
								<label class="w3-text-red padding-left-8">{!! $errors->first('file') !!}</label>
							@elseif (\Session::has('invalid'))
								<label class="w3-text-red padding-left-8">{!! array_values(\Session::get('invalid'))[0] !!}</label>
							@else
								<label>&nbsp;</label>
							@endif
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
	$('#file').change(function(event){
		$(this).prev().html(event.target.files[0].name)
			.prev().find('i').attr('class','button-icon-loader')
			.parents('form').trigger('submit');
	});
</script>
@endSection