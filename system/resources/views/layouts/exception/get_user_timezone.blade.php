<form id="myForm" method="POST" action="{{$action}}">
	@csrf
	<input id="userTimezone" type="hidden" name="timezone">
	<input type="hidden" name="redirect" value="{{$redirect}}">
</form>
<script>
	document.getElementById('userTimezone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
	document.getElementById("myForm").submit(); 
</script>