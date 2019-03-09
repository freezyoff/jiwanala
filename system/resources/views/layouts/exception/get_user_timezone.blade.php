<form id="myForm" method="POST" action="{{$action}}">
	@csrf
	<input id="userTimezone" type="hidden" name="timezone">
	<input type="hidden" name="redirect" value="{{$redirect}}">
</form>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.23/moment-timezone-with-data.min.js"></script>
<script>
	var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
	//console.log(timezone);
	if (!timezone){
		//client not support Intl.DateTimeFormat().resolvedOptions().timeZone
		timezone=moment.tz.guess()
		//console.log(moment.tz.guess());
	}
	document.getElementById('userTimezone').value = timezone;
	document.getElementById("myForm").submit();
</script>