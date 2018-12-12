@extends('layouts.dashboard.dashboard', ['sidebar'=>'bauk', 'title'=>trans('my/bauk/attendance/landing.page.title')])

@section('html.head.styles')
@parent

@endSection

@section('dashboard.main')
<form action="{{route('my.bauk.attendance')}}" method="post" enctype="multipart/form-data">
	@csrf
	<input name="import" type="file" accept=".csv" />
	<button name="submit" type="submit">Submit</button>
</form> 

	@if (isset($imported))
		<table class="w3-table">
			<thead>
				<tr>
					<td>NIP</td>
					<td>Tanggal</td>
					<td>Finger Masuk</td>
					<td>Finger Keluar</td>
					<td>Finger Keluar 2</td>
					<td>Finger Keluar 3</td>
					<td>Finger Keluar 4</td>
					<td>Finger Keluar 5</td>
				</tr>
			</thead>
			<tbody>
				@foreach($imported as $row)
					<tr>
						<td>
							<span class="input-label" input-field-name="row[][nip]">{{$row['nip']}}</span>
							<input name="row[][nip]" class="input-field" type="text" value="{{$row['nip']}}" />
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif
@endSection

@section('html.body.scripts')
@parent
<script>
App.UI.inputLabelAndField = function(){
	var td = {
		init: function(){
			this.inputEvents( $('.w3-table tbody tr td input.input-field').hide() );
			this.labelEvents( $('.w3-table tbody tr td span.input-label').css('cursor','pointer') );
		},
		labelEvents: function(elements){
			elements.on({
				click: function(){ $(this).hide(); $(this).next().show().focus(); },
				keyup:function(e){ if (e.keyCode == 13){ $(this).trigger('click'); }
				}
			});
		},
		inputEvents: function(elements){
			elements.on({
				blur: function(){ $(this).hide(); $(this).prev().show(); },
				focusout: function(){ $(this).trigger('blur'); },
				keyup: function(e){ if (e.keyCode == 27) $(this).trigger('blur'); }
			})
		}
	}
	
	td.init();
}

$(document).ready(function(){
	App.UI.inputLabelAndField();
});
</script>
@endSection