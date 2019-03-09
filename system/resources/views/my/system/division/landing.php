@extends('layouts.dashboard.dashboard', ['sidebar'=>'system', 'title'=>trans('my/system/division.titles.landing')])

@section('dashboard.main')
<div class="w3-card">
	<header class="w3-container w3-theme padding-top-bottom-8">
		<h4>{{trans('my/system/division.subtitles.landing')}}</h4>
	</header>
	<div class="padding-top-bottom-8">
		<div class="w3-row w3-container">
			<form name="search" action="{{route('my.system.user.index')}}" method="post">
				@csrf
				<div class="w3-col s12 m4 l4">
					<div class="input-group">
						<label><i class="fas fa-keyboard"></i></label>
						<input id="keywords" 
							name="keywords" 
							type="text" 
							class="w3-input" 
							placeholder="{{trans('my/system/user.hints.keywords')}}"
							value="{{old('keywords', $keywords)}}" />
					</div>
				</div>
			</form>
		</div>
	</div>	
</div>
@endSection

@section('html.body.scripts')
@parent
<script>
$(document).ready(function(){
	
});
</script>
@endSection
