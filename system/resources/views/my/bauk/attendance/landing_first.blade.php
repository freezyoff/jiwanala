<div id="step-1" class="{{isset($step) && $step==2? 'w3-hide' : ''}}">
	<div id="small" class="w3-display-middle w3-hide-medium w3-hide-large">
		<div style="text-align:center">
			<label for="inpUpload" class="w3-xxlarge w3-card btn-upload">
				<i class="fas fa-cloud-upload-alt fa-fw"></i>
			</label>
		</div>
		<i class="fa loader w3-hide"></i>
		<div class="w3-xlarge" style="margin:10px; text-align:center; font-weight:500;">Upload File</div>
		@if ($errors->has('upload'))
		<div class="w3-medium w3-text-red" style="margin:10px; text-align:center;">
			{{$errors->first('upload')}}
		</div>
		@endif
	</div>
	<div id="medium" class="w3-container w3-hide-small w3-hide-large"></div>
	<div id="large" class="w3-container w3-hide-small w3-hide-medium"></div>
	<form id="fmUpload" action="{{route('my.bauk.attendance')}}" method="post" enctype="multipart/form-data">
		@csrf
		<input name="step" value="1" type="hidden" />
		<input id="inpUpload" name="upload" type="file" accept=".csv" class="w3-hide" />
	</form>
</div>