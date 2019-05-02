<div class="w3-row w3-container">
	<div class="w3-col s12 m12 l8 schedule">
		@include('my.bauk.schedule.landing_employee')
		@include('my.bauk.schedule.landing_default_form')
	</div>
	<div class="w3-col l4 w3-hide-small w3-hide-medium padding-left-16">
		<h6 style="font-weight:600; margin-top:8px;">1. Cari NIP / Nama</h6>
		<p>Buka data dengan mengisi pecarian. Pilih data karyawan yang dikehendaki. Data yang dipilih dimuat NIP dan Nama dibawah.</p>
		<h6 style="font-weight:600; margin-top:8px;">2. Hari & Jam Kerja</h6>
		<p>Centang Hari Kerja sebelum mengisi Jam Masuk dan Jam Pulang. Jam Kerja menggunakan format 24 Jam.</p>
		<h6 style="font-weight:600; margin-top:8px;">3. Simpan</h6>
		<p>Pastikan Hari Kerja dan Jam Kerja sesuai yang anda kehendaki.</p>
		<p>Hari Kerja dicentang <i class="fa-square fa-fw fas w3-hover-text-blue w3-text-blue"></i>, akan disimpan oleh sistem.</p>
		<p>Hari Kerja yang tidak dicentang <i class="fa-square fa-fw far w3-text-blue"></i>, dihapus dari sistem.</p>
	</div>
</div>