@extends('dashboard.default.defaultDashboard')

@section('html.body.page.subHeader.quickAction')
@endSection

@section('html.head.styles')
	@parent
	<link href="{{asset('vendors/metronic/vendors/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"></link>
@endSection

@section('html.body.scripts.vendor')
	@parent
	<script src="{{asset('vendors/metronic/vendors/custom/datatables/datatables.bundle.js')}}" type="text/javascript"></script>
	<!--<script src="./assets/demo/default/custom/crud/datatables/basic/paginations.js" type="text/javascript"></script>-->
@endSection


@section('html.body.scripts.page')
	<script src="{{asset('js/bauk/default/mnjkaryawan/landing.js')}}" type="text/javascript"></script>
@endSection

@section('html.head.metas')
	@parent
	<meta name="dropdown-hapus-url" content="{{route('bauk.mnjkaryawan.hapus')}}" />
	<meta name="dropdown-rubah-url" content="{{route('bauk.mnjkaryawan.rubah')}}" />
@endSection

@section('html.body.page.content')
<div class="row">
	<div class="col-lg-12">
		<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
			<div class="m-portlet__body">
				<div class="btn-toolbar justify-content-between" role="toolbar" aria-label="Toolbar with button groups">
					<div class="btn-group" role="group" aria-label="First group">
						<button type="button" class="m-btn m-btn m-btn--square btn btn-primary" onClick="document.location='{{route('bauk.mnjkaryawan.tambah')}}'">
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
				
				<div id="table1" sourceUrl="{{route('bauk.mnjkaryawan.layanan.getTableDataKarayawan')}}"></div>
			</div>
		</div>
	</div>
</div>
<div id="modal-container"></div>
@endSection