<div id="attendanceProgress" class="w3-col s12 m6 l6 w3-light-grey">
	<div class="w3-card w3-light-grey">
		<header class="w3-container padding-top-8">
			<h4>Progres Rekaman Finger Kehadiran</h4>
		</header>
		<div class="w3-container padding-top-16 padding-bottom-16">
			<div class="w3-col s12 m12 l5 margin-bottom-8 margin-none-large" style="min-width:135px">
				<div style="display:flex; flex-direction:column;align-items:center;">
					<div id="progressbar-radial" 
						class="progressbar radial xlarge" 
						style="font-size:9em;box-shadow:2px 1px 10px .1px #898383 inset; ">
						<span><i class="button-icon-loader"></i></span>
						<div class="slice">
							<div class="bar"></div>
							<div class="fill"></div>
						</div>
					</div>
					<span class="padding-top-8" style="font-size:.7em; text-align:center">
						Progres rekaman kehadiran karyawan fulltime
					</span>
				</div>
			</div>
			<div class="w3-col s12 m12 l7">
				<table class="w3-table w3-bordered">
					<tbody>
						<tr>
							<td>Aktif</td>
							<td>:</td>
							<td id="employee-active" style="text-align:right"><i class="button-icon-loader"></i></td>
						</tr>
						<tr>
							<td>Fulltime</td>
							<td>:</td>
							<td id="employee-fulltime" style="text-align:right"><i class="button-icon-loader"></i></td>
						</tr>
						<tr>
							<td>Fulltime Kontrak thn ke 2</td>
							<td>:</td>
							<td id="employee-fulltime-contract-2" style="text-align:right"><i class="button-icon-loader"></i></td>
						</tr>
						<tr>
							<td>Fulltime Kontrak thn ke 1</td>
							<td>:</td>
							<td id="employee-fulltime-contract-1" style="text-align:right"><i class="button-icon-loader"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<style>
.progressbar.radial *{box-sizing:content-box;}

.progressbar.radial{
	position: relative;
	font-size: 120px;
	width: 1em;
	height: 1em;
	border-radius: 50%;
	background-color: #cccccc;
}

.progressbar.radial:after{
	position: absolute;
	top: 0.08em;
	left: 0.08em;
	display: block;
	content: " ";
	border-radius: 50%;
	background-color: #f5f5f5;
	width: 0.84em;
	height: 0.84em;
	-webkit-transition-property: all;
	-moz-transition-property: all;
	-o-transition-property: all;
	transition-property: all;
	-webkit-transition-duration: 0.2s;
	-moz-transition-duration: 0.2s;
	-o-transition-duration: 0.2s;
	transition-duration: 0.2s;
	-webkit-transition-timing-function: ease-in;
	-moz-transition-timing-function: ease-in;
	-o-transition-timing-function: ease-in;
	transition-timing-function: ease-in;
}

.progressbar.radial span{
	position: absolute;
	width: 100%;
	z-index: 1;
	left: 0;
	top: 0;
	width: 5em;
	line-height: 5em;
	font-size: 0.2em;
	color: #307bbb;
	display: block;
	text-align: center;
	white-space: nowrap;
	-webkit-transition-property: all;
	-moz-transition-property: all;
	-o-transition-property: all;
	transition-property: all;
	-webkit-transition-duration: 0.2s;
	-moz-transition-duration: 0.2s;
	-o-transition-duration: 0.2s;
	transition-duration: 0.2s;
	-webkit-transition-timing-function: ease-out;
	-moz-transition-timing-function: ease-out;
	-o-transition-timing-function: ease-out;
	transition-timing-function: ease-out;
}


.progressbar.radial .slice .bar,
.progressbar.radial .slice .fill{
	position: absolute;
	border: 0.08em solid #307bbb;
	width: 0.84em;
	height: 0.84em;
	clip: rect(0em, 0.5em, 1em, 0em);
	border-radius: 50%;
	-webkit-transform: rotate(0deg);
	-moz-transform: rotate(0deg);
	-ms-transform: rotate(0deg);
	-o-transform: rotate(0deg);
	transform: rotate(0deg);
}

.progressbar.radial .slice{position: absolute;width: 1em;height: 1em;clip: rect(0em, 1em, 1em, 0.5em);}
.progressbar.radial .slice.full{clip: rect(auto, auto, auto, auto) !important;}

</style>
<script>
var attendanceProgress = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.attendanceProgress')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			var duration =  1000,
				percent = response,
				angel = (percent/100)*360,
				pbar = $('#progressbar-radial'),
				span = pbar.find('span'),
				slice = pbar.find('.slice');
			
			$({countNum: 0, deg: 0}).animate({countNum: percent, deg: angel}, {
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
						slice.find('.fill').css('transform','rotate('+ this.deg +'deg)');
					}
				}
			});
		}
	});
};

var employeesCount = function(){
	$.ajax({
		method: "POST",
		url: '{{route('my.bauk.landing.info.employeesCount')}}',
		data: { '_token': '{{csrf_token()}}' },
		dataType: "json",
		beforeSend: function() {},
		success: function(response){
			$('#employee-active').html(response.count+' org');
			$('#employee-fulltime').html(response.fulltime+' org');
			$('#employee-fulltime-contract-1').html(response.contract1+' org');
			$('#employee-fulltime-contract-2').html(response.contract2+' org');
		}
	});
};

$(document).ready(function(){
	attendanceProgress();
	employeesCount();
	setInterval(attendanceProgress, 1000*60*10);
	setInterval(employeesCount, 1000*60*10);
});
</script>