<table class="w3-table-all">
	<thead>
		<tr class="w3-theme-l1">
			<?php $head = trans('my/bauk/attendance/hints.table.head'); ?>
			<th width="150px">{{$head[0]}}</th>
			<th>{{$head[1]}}</th>
			<th width="60px"></th>
		</tr>
	</thead>
	<tbody>
		@if($nip)
			@foreach($attendances as $attKey=>$attendance)
				<tr class="{{$attendance['holiday']? 'w3-red' : ''}}">
					<td>
						<span style="width:60px;display:inline-block">{{$attendance['label_dayofweek']}}</span> 
						<span style="padding-left:4px">{{$attendance['label_date']}}</span>
					</td>
					
					{{-- ada data kehadiran --}}
					<td>
						@if ($attendance['holiday'])
							{{$attendance['holiday']}}
						@else
							@if ($attendance['record'])
								<div class="w3-row">
								@foreach([1,2,3,4] as $index)
									@if ( $attendance['record']->{'time'.$index} )
									<div class="w3-col s12 m6 l3">
										<i class="fas fa-sign-{{$index>1? 'out' : 'in'}}-alt fa-fw"></i>
										<span class="padding-left-8">{{$attendance['record']->{'time'.$index} }}</span>
									</div>
									@endif
								@endforeach
								</div>
							@endif
							@if ($attendance['record'] && $attendance['record']->consent)
								<div class="w3-row">
									<i class="fas fa-exclamation-circle fa-fw"></i>
									<span class="padding-left-8">{{ trans('my/bauk/attendance/consent.types.'.$attendance['record']->consent)}}</span>
								</div>
							@endif
						@endif
					</td>
					
					<td style="text-align:right">
						{{-- data kehadiran tidak dikunci --}}
						@if (!$attendance['locked'] && !$attendance['holiday'])
							<a 	href="{{$attendance['link_finger']}}" title="kehadiran/finger"><i class="fas fa-fingerprint"></i></a>
							<a href="{{$attendance['link_consent']}}" class="padding-left-8" title="izin/cuti">
								<i class="far fa-calendar-check"></i>
							</a>
						@endif
					</td>
				</tr>
			@endforeach
		@else
			<tr>
				<td colspan="3">{{trans('my/bauk/attendance/hints.table.empty')}}</td>
			</tr>
		@endif
	</tbody>
</table>