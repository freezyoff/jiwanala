<?php  
	$trans = 'my/baak/student/landing';
?>

@extends('layouts.dashboard.dashboard', ['title'=>trans("$trans.title"), 'sidebar'=>'baak'])

@section('dashboard.main')
<div class="w3-row">
	<div class="w3-card">
		<header class="w3-container w3-theme padding-top-8 padding-bottom-8">
			<h4>{{trans('my/bauk/holiday.subtitles.landing')}}</h4>
		</header>
		<div class="w3-row w3-container">
			<button class="w3-button w3-blue w3-hover-indigo margin-top-8" 
				onclick="document.location='{{route('my.baak.student.add')}}'">
				<i class="fas fa-plus fa-fw"></i>
				<span class="margin-left-8">Tambah Siswa</span>
			</button>
			<form name="search" action="" method="post">
				@csrf
				<div class="input-group padding-left-8 padding-none-small margin-top-bottom-8">
					<label><i class="fas fa-keyboard"></i></label>
					<input name="keywords" type="text" class="w3-input" value="" placeholder="{{trans("$trans.hints.keywords")}}" />
				</div>
			</form>
		</div>
		<div class="w3-row w3-container padding-bottom-16">
			<table class="w3-table w3-table-all">
				<thead>
					<tr class="w3-theme-l1">
						<td class="w3-hide-medium w3-hide-large"></td>
						@foreach(trans("$trans.table.columns") as $col)
						<td>{{$col}}</td>
						@endforeach
						<td class="w3-hide-small"></td>
					</tr>
				</thead>
				<tbody>
					@forelse($students as $student)
					<tr>
						<td class="w3-hide-medium w3-hide-large"></td>
						<td>{{$student->nis}}</td>
						<td>{{$student->nisn}}</td>
						<td>{{$student->getFullName()}}</td>
						<td></td>
						<td class="w3-hide-small"></td>
					</tr>
					@empty
					<tr>
						<td colspan="5">
							{{trans("$trans.table.empty")}} <a href="{{route('my.baak.student.add')}}">{{trans("$trans.table.link")}}</a>
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
	</div>
</div>
@endSection

@section('html.body.scripts')
@parent
@endSection