<div id="attendanceProgress" class="w3-col s12 m6 l6 w3-light-grey">
	<div class="w3-card">
		<header class="w3-container padding-top-8 padding-bottom-8 w3-indigo">
			<h4>Progres Rekaman Finger Kehadiran</h4>
		</header>
		<div class="w3-row w3-indigo padding-left-8 padding-right-8 padding-bottom-8">
			<div class="w3-col s12 m6 l6">
				<div class="input-group">
					<label><i class="fas fa-calendar fa-fw"></i></label>
					<input id="attendanceProgress-month" 
						value="{{ $month }}"
						type="text" 
						class="w3-input" 
						role="select"
						select-dropdown="#attendanceProgress-month-dropdown"
						select-modal="#attendanceProgress-month-modal"
						select-modal-container="#attendanceProgress-month-modal-container" />
				</div>
				@include('my.bauk.landing_attendanceDocumentationProgress_month_dropdown')
				@include('my.bauk.landing_attendanceDocumentationProgress_month_modal')
			</div>
			<div class="w3-col s12 m6 l6 padding-left-8 padding-none-small">
				<div class="input-group">
					<label><i class="fas fa-calendar fa-fw"></i></label>
					<input id="attendanceProgress-year" 
						value="{{ $year }}"
						type="text" 
						class="w3-input" 
						role="select"
						select-dropdown="#attendanceProgress-year-dropdown"
						select-modal="#attendanceProgress-year-modal"
						select-modal-container="#attendanceProgress-year-modal-container" />
				</div>
				@include('my.bauk.landing_attendanceDocumentationProgress_year_dropdown')
				@include('my.bauk.landing_attendanceDocumentationProgress_year_modal')
			</div>
		</div>
		<div class="w3-container padding-top-16 padding-bottom-16">
			<div class="w3-col s12 m12 l12 margin-bottom-8 margin-none-large padding-top-8" style="min-width:135px">
				<div style="display:flex; flex-direction:column;align-items:center;">
					<div id="progressbar-radial" 
						class="progressbar radial xlarge" 
						style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset; ">
						<span id="progressbar-radial-label"><i class="button-icon-loader"></i></span>
						<div class="slice">
							<div class="bar"></div>
							<div class="fill"></div>
						</div>
					</div>
					<span id="progressbar-title"
						class="padding-top-8" 
						style="font-size:.7em; text-align:center">
						Progres rekaman karyawan fulltime
					</span>
				</div>
			</div>
			<div class="w3-col s12 m12 l12">
				<table class="w3-table w3-bordered">
					<tbody>
						@foreach(trans('my/bauk/attendance/hints.table.export') as $key=>$header)
							@if ($key == 'attendance' || $key=='attends' || $key=='absents' || $key=='work_days')
								@continue
							@endif
							<tr>
								<td>{!!$header!!}</td>
								<td id="attendanceProgress-{{$key}}"></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<script>
var attendanceProgress = {
	init: function(){
		$('#attendanceProgress-year, #attendanceProgress-month').on('select.pick', function(event, oldValue, newValue){
			if (oldValue != newValue){
				attendanceProgress.send();
			}
		});
		attendanceProgress.send();
	},
	send: function(){
		$.ajax({
			method: "POST",
			url: '{{route('my.bauk.attendanceDocumentationProgress')}}',
			data: { 
				'_token': '{{csrf_token()}}',
				'year': $('#attendanceProgress-year').val(),
				'month': $('#attendanceProgress-month').val(),
			},
			dataType: "json",
			beforeSend: function() {
				$('#progressbar-radial-label').html($('<i class="button-icon-loader"></i>'));
			},
			success: function(response){
				attendanceProgress.setProgressbar(response.attendance);
				$.each(response.keys, function(index, value){
					$('#attendanceProgress-'+value).html(response[value]);
				});
			}
		});
	},
	setProgressbar: function(percent){
		var duration =  1000,
			percent = percent,
			angel = (percent/100)*360,
			pbar = $('#progressbar-radial'),
			span = $('#progressbar-radial-label'),
			slice = pbar.find('.slice'),
			startAngel = parseInt(pbar.attr('angel')),
			startCount = parseInt(pbar.attr('percent'));
			
		$({countNum: isNaN(startAngel)? 0 : startAngel, deg: isNaN(startCount)? 0 : startCount}).animate({countNum: percent, deg: angel}, {
			duration: duration,
			easing:'linear',
			step: function() {
				span.html(Math.floor(this.countNum)+'%');
				slice.find('.bar').css('transform','rotate('+ this.deg +'deg)');
				
				if (this.deg>180){
					slice.addClass('full');
					slice.find('.fill').css('transform','rotate(180deg)');
				} 
				else{
					slice.removeClass('full');
					slice.find('.fill').css('transform','rotate('+ this.deg +'deg)');
				}
				pbar.attr('angel',angel);
				pbar.attr('percent',this.countNum);
			}
		});
	}
};

$(document).ready(function(){
	attendanceProgress.init();
	$('[role="select"]').select();
});
</script>