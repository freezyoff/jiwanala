@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/pages.titles.upload')])

@section('dashboard.main')
<div class="w3-card margin-bottom-16">
	<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
		<h4>{{trans('my/bauk/attendance/pages.titles.upload_report')}}</h4>
	</header>
	<div class="w3-row padding-top-bottom-8">
		<div class="w3-container">
			<div class="w3-responsive">
				<table class="w3-table w3-table-all">
					<thead id="heading">
						<tr class="w3-theme-l1">
							<td>Baris</td>
							<td>Kesalahan</td>
						</tr>
					</thead>
					<tbody>
						@foreach($import as $row=>$report)
						<tr>
							<td>{{$row-$lineOffset}}</td>
							<td>
								@if ($report['imported'])
									<div><span class="w3-tag w3-indigo">{{trans('my/bauk/attendance/hints.tags.upload_success')}}</span></div>
								@else
									<div><span class="w3-tag w3-orange">{{trans('my/bauk/attendance/hints.tags.upload_fail')}}</span></div>
									@foreach(array_except($report,['imported']) as $error=>$message)	
										<div>
											<span style="width:140px;display:inline-block">{{ $error=='nip'? strtoupper($error) : ucwords(str_replace('_',' ',$error)) }}</span>
											<span style="display:inline-block">:&nbsp;</span>
											<span class="w3-text-red" style="white-space:nowrap;display:inline-block">{{$message}}</span>
										</div>
									@endforeach
								@endif
							</td>
						</tr>
						@endforeach
					</tbody>
					<thead id="heading">
						<tr class="w3-theme-l1">
							<td>Baris</td>
							<td>Kesalahan</td>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	<div class="w3-container padding-bottom-8" style="text-align:right">
		<button class="w3-button w3-red w3-hover-red w3-mobile" onclick="$(this).find('i').attr('class','button-icon-loader-red');document.location='{{route('my.bauk.attendance.upload')}}'">
			<i class="fas fa-chevron-left fa-fw"></i>
			Kembali
		</button>
	</div>
</div>
@endSection