<table class="w3-table-all">
	<thead>
		<tr class="w3-theme-l1">
			<th>Hari Libur</th>
			<th>Tanggal</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		@forelse($holidays as $holiday)
		<tr>
			<td>{{$holiday->name}}</td>
			<td>
			<?php $range = $holiday->getDateRange(); ?>
				{{$range[0]->format('d F')}}
				@if($holiday->start != $holiday->end)
					s/d {{$range[1]->format('d F')}}
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
			<td colspan="2">{{trans('my/bauk/holiday.table.empty')}}</td>
		</tr>
		@endforelse
	</tbody>
</table>