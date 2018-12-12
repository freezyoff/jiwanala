<form id="fmUpload" action="{{route('my.bauk.attendance')}}" method="post" enctype="multipart/form-data">
	@csrf
	<input name="step" value="1" type="hidden" />
	<label for="inpUpload" class="w3-card w3-xxlarge" style="display:flex; flex-direction:column; padding:8px 16px">
		<div>1</div>
		<div>
			<i class="fas fa-cloud-upload-alt"></i>
			<span>Upload File</span>
		</div>
	</label>
	<input id="inpUpload" name="upload" type="file" accept=".csv" class="w3-hide" />
</form>
<script>
	App.UI.small = {
		init: function(){
			$('#inpUpload').change(function() {
				$('#fmUpload').submit();
			});
		}
	}

	$(document).ready(function(){
		App.UI.small.init();
	});
</script>