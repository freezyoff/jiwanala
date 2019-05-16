<?php  $trans = 'my/baak/student/add'; ?>

@extends('layouts.dashboard.dashboard', ['title'=>trans("$trans.title"), 'sidebar'=>'baak'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans($trans.'.subtitle')}}</h4>
		</header>
		<form action="{{route('my.baak.student.add')}}" 
			method="POST"
			class="w3-container">
			@csrf
			<input name="active" value="1" type="hidden" />
			
			<div class="margin-top-8">
				@include('my.baak.student.add_index_form')
			</div>
			
			<h5 class="margin-top-bottom-16">
				{{trans($trans.'.hints.personal_data')}}
			</h5>
			@include('my.baak.student.add_bio_form')
			
			<?php $headers = ['father', 'mother', 'guardian']; ?>
			@foreach($headers as $item)
				<div id="{{$item}}-container">
					<h5 class="margin-top-16 margin-bottom-16">
						{{trans($trans.'.hints.'.$item.'_data')}}
					</h5>
					@include('my.baak.student.add_guardian_form', ['prefix'=>$item])				
				</div>
			@endforeach
			
			<div class="w3-row margin-bottom-16">
				<button class="w3-button" type="submit">Submit</button>
			</div>
		</form>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
<script>

</script>
@endSection