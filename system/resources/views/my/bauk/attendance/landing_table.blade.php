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
				<tr class="
					@if (isset($attendance['holiday']) && $attendance['holiday'])
						w3-red
					@elseif (isset($attendance['consent']) && $attendance['consent'])
						w3-yellow
					@endif
					">
					<td>
						<span style="width:60px;display:inline-block">{{$attendance['label_dayofweek']}}</span> 
						<span style="padding-left:4px">{{$attendance['label_date']}}</span>
					</td>
					
					{{-- ada data kehadiran --}}
					<td>
						@if (isset($attendance['holiday']) && $attendance['holiday'])
							{{$attendance['holiday']}}	
						@endif
						@if (isset($attendance['attendance']) && $attendance['attendance'])
							<div class="w3-row">
								<div class="w3-col s12 m6 l3">
									<i class="fas fa-sign-in-alt fa-fw"></i>
									<span class="padding-left-8">{{$attendance['attendance']->time1}}</span>
								</div>
							@forelse([2, 3,4] as $index)
								@if ( $attendance['attendance']->{'time'.$index} )
								<div class="w3-col s12 m6 l3">
									<i class="fas fa-sign-{{$index>1? 'out' : 'in'}}-alt fa-fw"></i>
									<span class="padding-left-8">{{$attendance['attendance']->{'time'.$index} }}</span>
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
						@if (isset($attendance['hasWarning']) && $attendance['hasWarning'])
							<div class="w3-row">
							@foreach($attendance['warning'] as $tag)
								<div class="margin-top-8 margin-none-large margin-none-medium" style="display:inline-block">
									<span 
										class="margin-right-8 w3-tag w3-amber" 
										style="white-space:nowrap">{{$tag}}</span>
								</div>
							@endforeach
							</div>
						@endif
						@if (isset($attendance['consent']) && $attendance['consent'])
							<div class="w3-row">
								<i class="fas fa-exclamation-circle fa-fw"></i>
								<span class="padding-left-8">{{ trans('my/bauk/attendance/consent.types.'.$attendance['consent']->consent) }}</span>
							</div>
						@endif
					</td>
					
					<td style="text-align:right">
						{{-- data kehadiran tidak dikunci --}}
						@if (isset($attendance['holiday']) && !$attendance['holiday'] && isset($attendance['locked']) && !$attendance['locked'])
							@if (isset($attendance['link_finger']))
							<a class="w3-hover-text-blue" href="{{$attendance['link_finger']}}" title="kehadiran/finger"><i class="fas fa-fingerprint"></i></a>
							@endif
							@if(isset($attendance['link_consent']))
							<a class="w3-hover-text-green padding-left-8" href="{{$attendance['link_consent']}}" class="padding-left-8" title="izin/cuti"><i class="far fa-calendar-check"></i></a>
							@endif
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