<table class="w3-table-all">
	<thead>
		<tr class="w3-theme-l1">
			<?php $head = trans('my/bauk/attendance/hints.table.head'); ?>
			<th width="60px" class="w3-hide-medium w3-hide-large"></th>
			<th width="150px">{{$head[0]}}</th>
			<th>{{$head[1]}}</th>
			<th width="60px" class="w3-hide-small"></th>
		</tr>
	</thead>
	<tbody>
		@if($nip)
			@foreach($details as $date=>$data)
				<tr class="
					@if ($data['isHoliday'] || $data['isWeekEnd'])
						w3-red
					@elseif ($data['hasConsent'])
						<!--w3-yellow-->
					@endif
					">
					<td style="white-space:nowrap" class="w3-hide-medium w3-hide-large">
						{{-- data kehadiran tidak dikunci --}}
						@if (!$data['isHoliday'] && !$data['weekEnd'] && $data['allow_update'])
							<a class="w3-hover-text-blue" 
								href="{{$data['attend_update_url']}}" 
								title="kehadiran/finger">
								<i class="fas fa-fingerprint"></i>
							</a>
							<a class="w3-hover-text-green padding-left-8" 
								href="{{$data['consent_update_url']}}" 
								class="padding-left-8" 
								title="izin/cuti">
								<i class="far fa-calendar-check"></i>
							</a>
						@endif
					</td>
					
					<td>
						<span style="width:60px;display:inline-block">{{$data['dayOfWeek']}}</span> 
						<span style="padding-left:4px">{{$data['day']}}</span>
					</td>
					
					{{-- ada data kehadiran --}}
					<td>
						@if ($data['isWeekEnd'])
							{{$data['weekEnd']}}
						@elseif ($data['isHoliday'])
							{{$data['holiday']}}	
						@endif
						@if ($data['isAttend'])
							<div class="w3-row">
								<div class="w3-col s12 m6 l3">
									<i class="fas fa-sign-in-alt fa-fw"></i>
									<span class="padding-left-8">{{$data['attend']->time1}}</span>
								</div>
							@forelse([2, 3,4] as $index)
								@if ( $data['attend']->{'time'.$index} )
								<div class="w3-col s12 m6 l3">
									<i class="fas fa-sign-{{$index>1? 'out' : 'in'}}-alt fa-fw"></i>
									<span class="padding-left-8">{{$data['attend']->{'time'.$index} }}</span>
								</div>
								@endif
							@empty
								<div class="w3-col s12 m6 l3">
									<i class="fas fa-sign-out-alt fa-fw"></i>
									<span class="padding-left-8">{{$attendance['attendance']->time2 }}</span>
								</div>
							@endforelse
							</div>
						@endif
						@if ($data['hasReminder'])
							<div class="w3-row">
							@foreach($data['reminder'] as $key=>$tag)
								<span 
									class="margin-right-8 w3-tag w3-amber" 
									style="white-space:nowrap">{{$tag}}</span>
							@endforeach
							</div>
						@endif
						@if ($data['hasConsent'])
							<div class="w3-row w3-tag w3-indigo" 
								style="padding:4px 8px; cursor:pointer"
								onclick="$(this).find('#viewer-modal-{{$date}}').show()">
								<i class="fas fa-exclamation-circle fa-fw"></i>
								<span class="padding-left-8">
									{{ trans('my/bauk/attendance/consent.types.'.$data['consent']->consent) }}
								</span>
								@include('my.bauk.attendance.landing.details_table_pic_modal')
							</div>
						@endif
					</td>
					
					<td style="white-space:nowrap; text-align:right" class="w3-hide-small">
						{{-- data kehadiran tidak dikunci --}}
						@if (!$data['isHoliday'] && !$data['weekEnd'] && $data['allow_update'])
							<a class="w3-hover-text-blue" 
								href="{{$data['attend_update_url']}}" 
								title="kehadiran/finger">
								<i class="fas fa-fingerprint"></i>
							</a>
							<a class="w3-hover-text-green padding-left-8" 
								href="{{$data['consent_update_url']}}" 
								class="padding-left-8" 
								title="izin/cuti">
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