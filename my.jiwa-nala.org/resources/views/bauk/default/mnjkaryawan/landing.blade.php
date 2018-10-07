@extends('dashboard.default.defaultDashboard')

@section('html.body.page.subHeader.quickAction')
@endSection

@section('html.body.page.content')
<div class="row">
	<div class="col-lg-12">
		<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
			<div class="m-portlet__body">
				<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					<div class="btn-group" role="group" aria-label="First group">
						<button type="button" class="m-btn m-btn m-btn--square btn btn-primary">
							<i class="la la-user"></i> 
							Karyawan Baru
						</button>
						<span style="margin:0 5px"></span>
						<button type="button" class="m-btn m-btn m-btn--square btn btn-success">
							<i class="la la-paperclip"></i> 
							Upload Data
						</button>
					</div>
				</div>
				<div class="m-portlet__body-progress">Loading</div>
				<div style="padding: 10px 0;"></div>
				<div class="table-responsive">
					<table class="table m-table m-table--head-bg-info">
						<thead>
							<tr>
								<th>#</th>
								<th>First Name</th>
								<th>Last Name</th>
								<th>Username</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<th scope="row">1</th>
								<td>Jhon</td>
								<td>Stone</td>
								<td>@jhon</td>
							</tr>
							<tr>
								<th scope="row">2</th>
								<td>Lisa</td>
								<td>Nilson</td>
								<td>@lisa</td>
							</tr>
							<tr>
								<th scope="row">3</th>
								<td>Larry</td>
								<td>the Bird</td>
								<td>@twitter</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endSection