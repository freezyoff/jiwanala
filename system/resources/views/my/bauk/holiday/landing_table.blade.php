<table class="w3-table w3-table-all">
	<thead>
		<tr class="w3-theme-l1">
			<th>Hari Libur</th>
			<th>Tanggal</th>
			<th width="75px" style="text-align:center" width="20px">Berulang</th>
			<th width="75px"></th>
		</tr>
	</thead>
	<tbody>
		@forelse($holidays as $holiday)
		<tr>
			<td>{{$holiday->name}}</td>
			<td>
			<?php 
				$range = $holiday->getDateRange(); 
				if ($holiday->repeat) {
					$range[0]->year = $year;
					$range[1]->year = $year;
				}
			?>
				<span>{{ trans('calendar.days.long.'.($range[0]->dayOfWeek)) }},&nbsp;</span>
				<span>{{ $range[0]->format('d') }}&nbsp;</span>
				<span>{{ trans('calendar.months.long.'.($range[0]->format('n')-1)) }}&nbsp;</span>
				<span>{{ $range[0]->format('Y') }}</span>
				@if($holiday->start != $holiday->end)
					<span style="padding:0 8px;"><i class="fas fa-minus"></i></span>
					<span>{{ trans('calendar.days.long.'.($range[1]->dayOfWeek)) }},&nbsp;</span>
					<span>{{ $range[1]->format('d') }}&nbsp;</span>
					<span>{{ trans('calendar.months.long.'.($range[1]->format('n')-1)) }}&nbsp;</span>
					<span>{{ $range[0]->format('Y') }}</span>
				@endif
			</td>
			<td style="text-align:center">
				@if ($holiday->repeat)
					<i class="fas fa-redo fa-fw"></i>
				@endif
			</td>
			<td style="text-align:right">
				<a class="w3-hover-text-green loader" 
					style="cursor:pointer" 
					onclick="
						$(this).find('i').removeClass('fa-edit').addClass('button-icon-loader'); 
						document.location='{{route('my.bauk.holiday.edit',[$holiday->id])}}'">
					<i class="fas fa-edit fa-fw"></i>
				</a>
				<a class="w3-hover-text-red padding-left-8 loader" 
					style="cursor:pointer" 
					onclick="$('#delete-modal-{{$holiday->id}}').show()">
					<i class="fas fa-trash fa-fw"></i>
				</a>
				@include('my.bauk.holiday.landing_table_modal')
			</td>
		</tr>
		@empty
		<tr>
			<td colspan="3">{{trans('my/bauk/holiday.table.empty')}}</td>
		</tr>
		@endforelse
	</tbody>
</table>