<div class="w3-row">
	<div style="display:flex; justify-content:space-evenly">
		<div style="display:flex; flex-direction:column;align-items:center;margin-top:8px;">
			<div id="summarybar-radial" 
				class="progressbar radial xlarge" 
				style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset;">
				<span id="summarybar-radial-label"><i class="button-icon-loader"></i></span>
				<div class="slice">
					<div class="bar"></div>
					<div class="fill"></div>
				</div>
			</div>
			<span id="summarybar-title" class="padding-top-8" style="font-size:.7em; text-align:center"></span>
		</div>
	</div>
</div>
<div class="w3-row">
	<table class="w3-table w3-bordered">
		<tbody>
			@foreach(trans('my/bauk/attendance/hints.table.export') as $key=>$header)
				@if ($key == 'attendance' || $key=='attends' || $key=='absents' || $key=='work_days')
					@continue
				@endif
				<tr>
					<td>{!!$header!!}</td>
					<td id="attendanceSummary-{{$key}}">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>
<script>
var attendanceSummary = {
	init: function(){
		$('#summary-year').on('select.pick', function(event, oldValue, newValue){
			if (oldValue != newValue){
				attendanceSummary.send();	
			}
		});
		attendanceSummary.send();
	},
	send: function(){
		$.ajax({
			method: "POST",
			url: '{{route('my.bauk.attendanceDocumentationSummary')}}',
			data: { 
				'_token': '{{csrf_token()}}',
				'year': $('#attendanceSummary-year').val(),
				'month': $('#attendanceSummary-month').val(),
			},
			dataType: "json",
			beforeSend: function() {
				$('#summarybar-radial-label').html($('<i class="button-icon-loader"></i>'));
			},
			success: function(response){
				attendanceSummary.setProgressbar(response.attendance);
				$.each(response.keys, function(index, value){
					$('#attendanceSummary-'+value).html(response[value]);
				});
			}
		});
	},
	setProgressbar: function(percent){
		var duration =  1000,
			percent = percent,
			angel = (percent/100)*360,
			pbar = $('#summarybar-radial'),
			span = $('#summarybar-radial-label'),
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
</script>