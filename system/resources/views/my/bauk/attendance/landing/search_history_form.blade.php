<form id="searchHistory" action="{{route('my.bauk.attendance.landing')}}" method="POST">
	@csrf
	<input name="ctab" value="{{$ctab? $ctab : 'tab-item-summary'}}" type="hidden" />
	<input name="nip" value="{{$nip? $nip : ''}}" type="hidden" />
	<input name="month" value="{{$month? $month : now()->format('m')}}" type="hidden" />
	<input name="year" value="{{$year? $year : now()->format('Y')}}" type="hidden" />
</form>