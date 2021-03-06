<div class="w3-row">
	<div style="display:flex; justify-content:space-evenly">
		<div style="display:flex; flex-direction:column;align-items:center;margin-top:8px;">
			<div id="progressbar-radial" 
				class="progressbar radial xlarge" 
				style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset;">
				<span id="progressbar-radial-label"><i class="button-icon-loader"></i></span>
				<div class="slice">
					<div class="bar"></div>
					<div class="fill"></div>
				</div>
			</div>
			<span id="progressbar-title" class="padding-top-8" style="font-size:.7em; text-align:center"></span>
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
					<td id="attendanceProgress-{{$key}}">
						<i class="button-icon-loader"></i>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
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
</script>