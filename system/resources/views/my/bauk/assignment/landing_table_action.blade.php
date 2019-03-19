<div id="action-dropdown-{{$employee->id}}" class="w3-card w3-dropdown-content w3-bar-block w3-animate-opacity w3-hide-small w3-hide-medium"
	style="right:32px;">
	<ul class="w3-ul w3-hoverable">
		<li style="cursor:pointer;">
			<?php 
				$assignAction = route('my.bauk.assignment.assign',[
					'division'=>$division->code,
					'employee'=>$employee->nip
				]);
			?>
			<a class="w3-text-theme w3-mobile" 
				href="{{$assignAction}}">
				{{"tugaskan ke ".$division->name}}
			</a>
			<a class="w3-text-theme w3-mobile" 
				href="{{$assignAction}}">
				{{"tugaskan ke ".$division->name." sebagai ". \App\Libraries\Core\JobPosition::find('2.4')->alias}}
			</a>
		</li>
	</ul>
</div>