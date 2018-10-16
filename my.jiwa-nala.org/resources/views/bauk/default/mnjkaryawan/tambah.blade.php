@extends('dashboard.default.defaultDashboard')

@section('html.body.page.subHeader.quickAction')
@endSection

@section('html.head.styles')
	@parent
@endSection

@section('html.body.scripts.vendor')
	@parent
	<script src="{{asset('vendors/metronic/demo/default/custom/crud/forms/widgets/bootstrap-select.js') }}" type="text/javascript"></script>
@endSection

@section('html.body.scripts.page')
<script src="{{asset('js/bauk/default/mnjkaryawan/tambah.js')}}" type="text/javascript"></script>
<script type="text/javascript">
	bauk_default_mnjkaryawan_tambah.options[0].rules.remote.url = '{{route("bauk.mnjkaryawan.uniqueNIP")}}';
</script>
@endSection

@section('html.body.page.content')
<div class="row">
	<div class="col-lg-12">
		<div class="m-portlet m-portlet--mobile m-portlet--body-progress-">
			<form id="form1" class="m-form m-form--state m-form--fit m-form--label-align-right" action="{{route('bauk.mnjkaryawan.tambah')}}" method="POST">
				@csrf
				<div class="m-portlet__body">
					<div class="form-group m-form__group">
						<label>Nomor Induk Pegawai</label>
						<div id="inpNipLoader" class="">
							<input name="NIP" id="inpNip" maxlength="20" 
								class="form-control m-input" 
								placeholder="Nomor Induk" type="text">
						</div>
					</div>
					<div class="form-group m-form__group">
						<label>Nomor Kartu Tanda Penduduk (KTP)</label>
						<input name="KTP" id="inpKtp" maxlength="25" class="form-control m-input"  placeholder="Nomor KTP" type="text">
					</div>
					<div class="form-group m-form__group row NamaDanGelar">
						<div class="col-lg-3 m-form__group-sub">
							<label id="lbNamaDanGelar">Nama & Gelar</label>
							<input name="nama_gelar_depan" id="inpNamaGd" maxlength="50" class="form-control m-input" placeholder="Gelar Depan" type="text">
						</div>
						<div class="col-lg-6 m-form__group-sub">
							<label>&nbsp;</label>
							<input name="nama_lengkap" id="inpNamaNn" maxlength="100" class="form-control m-input" placeholder="Nama Lengkap" type="text">
						</div>
						<div class="col-lg-3 m-form__group-sub">
							<label>&nbsp;</label>
							<input name="nama_gelar_belakang" id="inpNamaGb" maxlength="50" class="form-control m-input" placeholder="Gelar Belakang" type="text">	
						</div>
					</div>
					<div class="form-group m-form__group row Alamat" style="padding-bottom:0">
						<div class="col-lg-12 m-form__group-sub">
							<label id="lbAlamat">Alamat</label>
							<input name="alamat" id="inpAlamat" class="form-control" maxlength="200" placeholder="Alamat Lengkap" type="text">
						</div>
					</div>
					<div class="m--visible-desktop" style="padding-top:15px"></div>
					<div class="form-group m-form__group row Alamat" style="padding-top:0; padding-bottom:0">
						<div class="col-lg-2 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="rt" id="inpRt" maxlength="3" class="form-control m-input" placeholder="RT" type="text">
						</div>
						<div class="col-lg-2 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="rw" id="inpRw" maxlength="3" class="form-control m-input" placeholder="RW"  type="text">
						</div>
						<div class="col-lg-4 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="kelurahan" id="inpKelurahan" maxlength="50" class="form-control m-input" placeholder="Kelurahan"  type="text">
						</div>
						<div class="col-lg-4 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="kecamatan" id="inpKecamatan" maxlength="50" class="form-control m-input" placeholder="Kecamatan" type="text">
						</div>
					</div>
					<div class="m--visible-desktop" style="padding-top:15px"></div>
					<div class="form-group m-form__group row Alamat" style="padding-top:0">
						<div class="col-lg-4 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="kota" id="inpKota" maxlength="50" class="form-control m-input" placeholder="Kota"  type="text">
						</div>
						<div class="col-lg-4 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="provinsi" id="inpProvinsi" maxlength="50" class="form-control m-input" placeholder="Provinsi"  type="text">
						</div>
						<div class="col-lg-4 m-form__group-sub">
							<label class="m--visible-tablet-inline-block m--visible-mobile-inline-block">&nbsp;</label>
							<input name="kode_pos" id="inpKodePos" maxlength="20" class="form-control m-input" placeholder="Kode Pos" type="text">
						</div>
					</div>	
					<div class="form-group m-form__group row Telepon">
						<div class="col-lg-6 m-form__group-sub">
							<label>Telepon</label>
							<input name="tlp1" id="inpTlp1" maxlength="20" class="form-control" maxlength="25" placeholder="Telepon Rumah" type="text">
						</div>
						<div class="col-lg-6 m-form__group-sub">
							<label>&nbsp;</label>
							<input name="tlp2" id="inpTlp2" maxlength="20" class="form-control" maxlength="25" placeholder="Telepon Selular" type="text">
						</div>
					</div>
					<div class="form-group m-form__group">
						<label>Status Pernikahan</label>
						<select name="status_pernikahan" id="inpStatusNk" class="form-control m-bootstrap-select m_selectpicker" title="Pilih salah satu">
							<option value="bm">Belum Menikah</option>
							<option value="mn">Menikah</option>
							<option value="cr">Duda/Janda Cerai</option>
							<option value="mt">Duda/Janda Mati</option>
						</select>
						<div id="inpStatusNk-error" class="form-control-feedback m--hide"></div>
					</div>
					<div class="form-group m-form__group date">
						<label>Tanggal Terdaftar</label>
						<input name="tanggal_masuk" id="inpTglDf" maxlength="1000" class="form-control m-input" readonly="readonly" type="text">
					</div>
				</div>
				<div class="m-portlet__foot m-portlet__foot--fit">
				<div class="m-form__actions m-form__actions--solid m-form__actions--right">
					<button id="btnSubmit" type="submit" name="simpan" class="btn btn-primary">
						<span class="m-loader m--hide" style="margin:0 15px 0 10px"></span>
						 Simpan
					</button>
					<button type="reset" name="batal" class="btn btn-secondary" onclick="document.location='{{route('bauk.mnjkaryawan')}}'">Batal</button>
				</div>
			</div>
			</form>
		</div>
	</div>
</div>
@endSection