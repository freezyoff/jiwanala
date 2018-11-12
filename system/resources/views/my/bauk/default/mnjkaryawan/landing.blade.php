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
	<script src="{{asset('vendors/metronic/demo/default/custom/crud/forms/widgets/bootstrap-select.js')}}" type="text/javascript"></script>
	<!--<script src="./assets/demo/default/custom/crud/datatables/basic/paginations.js" type="text/javascript"></script>-->
	<script src="{{asset('vendors/cowboy/jquery-throttle-debounce.js')}}" type="text/javascript"></script>
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
						<div class="dropdown">
							<button class="btn btn-primary dropdown-toggle" type="button" id="importDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-cloud-upload-alt"></i> Import Data
							</button>
							<div class="dropdown-menu" aria-labelledby="importDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
								<a class="dropdown-item export" href="route('bauk.mnjkaryawan.tambah')">
									<i class="la la-file-excel-o"></i> Karyawan Baru
								</a>
								<a class="dropdown-item export" href="route('bauk.mnjkaryawan.tambah')">
									<i class="fa fa-file"></i> Upload File
								</a>
							</div>
						</div>
						<span style="margin:0 5px"></span>
						<div class="dropdown">
							<button class="btn btn-warning dropdown-toggle" type="button" id="exportDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-cloud-download-alt"></i> Ekspor
							</button>
							<div class="dropdown-menu" aria-labelledby="exportDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 40px, 0px);">
								<form action="{{route('bauk.mnjkaryawan.ekspor')}}" method="POST">
									@csrf
									<input type="hidden" name="format" value="csv">
									<a class="dropdown-item export" href="#">
										<i class="la la-file-excel-o"></i> CSV - Comma Separated Value
									</a>
								</form>
								<form action="{{route('bauk.mnjkaryawan.ekspor')}}" method="POST">
									@csrf
									<input type="hidden" name="format" value="xls">
									<a class="dropdown-item export" href="#">
										<i class="la la-file-excel-o"></i> XLS - Excel
									</a>
								</form>
								<form action="{{route('bauk.mnjkaryawan.ekspor')}}" method="POST">
									@csrf
									<input type="hidden" name="format" value="xlsx">
									<a class="dropdown-item export" href="#">
										<i class="la la-file-excel-o"></i> XLSX - Latest Excel
									</a>
								</form>
								<form action="{{route('bauk.mnjkaryawan.ekspor')}}" method="POST">
									@csrf
									<input type="hidden" name="format" value="pdf">
									<a class="dropdown-item export" href="#">
										<i class="la la-file-pdf-o"></i> PDF - Portable Document
									</a>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="m-portlet__body-progress">Loading</div>
				<div style="padding: 10px 0;"></div>

				
<form id="formSearch" action="" class="m-form m-form--state m-form--fit m-form--label-align-right" method="POST" novalidate="novalidate">
	<div class="form-group m-form__group row" style="padding-left:0; padding-right:0; padding-bottom:15px">
		<div class="col-lg-3 m-form__group-sub">
			<label id="lbStatusNk">Status Pernikahan</label>
			<select name="status_pernikahan" id="inpStatusNk" class="form-control m-bootstrap-select m_selectpicker" title="Semua Data">
				<option value="bm">Semua Data</option>
				<option value="bm">Belum Menikah</option>
				<option value="mn">Menikah</option>
				<option value="cr">Duda/Janda Cerai</option>
				<option value="mt">Duda/Janda Mati</option>
			</select>
		</div>
		<div class="col-lg-9 m-form__group-sub">
			<label id="lbKeywords">Kata Kunci</label>
			<input name="nama_lengkap" id="inpKeywords" maxlength="100" class="form-control m-input" placeholder="Nomor Induk Pegawai" value="" type="text">
		</div>
	</div>
</form>				
				
				<div id="table1" sourceUrl="{{route('bauk.mnjkaryawan.layanan.getTableDataKarayawan')}}"></div>
			</div>
		</div>
	</div>
</div>
<div id="modal-container"></div>
@endSection